<?php

namespace App\Http\Controllers;

use App\Models\FinancialLog;
use App\Models\LessonPackage;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\Invoice;
// use App\Models\LogKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\InvoiceNotification;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('handleWebhook');
        Configuration::setXenditKey(config('services.xendit.secret_key'));
    }

    // public function listPackages()
    // {
    //     return view('dashboard', [
    //         'lesson_packages' => LessonPackage::all(),
    //     ]);
    // }

    public function showCheckout($lessonPackageId)
    {
        $package = LessonPackage::findOrFail($lessonPackageId);
        return view('transaction.checkout', compact('package'));
    }

    public function createInvoice(Request $request)
    {
        $request->validate([
            'lesson_package_id' => 'required|exists:lesson_packages,lesson_package_id',
            'email' => 'required|email',
        ]);

        try {
            $package = LessonPackage::findOrFail($request->lesson_package_id);
            $user = Auth::user();

            if (!$user) {
                Log::error('User not authenticated in createInvoice');
                throw new \Exception('User not authenticated');
            }

            Log::info('Creating invoice for user: ' . $user->user_id . ', package: ' . $package->lesson_package_id);

            $apiInstance = new InvoiceApi();

            $external_id = 'invoice-' . time() . '-' . $user->user_id;
            $create_invoice_request = new CreateInvoiceRequest([
                'external_id' => $external_id,
                'amount' => $package->lesson_package_price,
                'payer_email' => $request->email,
                'description' => 'Pembayaran untuk paket ' . $package->lesson_package_name,
                'success_redirect_url' => url('/transaction/success'),
                'failure_redirect_url' => url('/transaction/failed'),
                'currency' => 'IDR',
            ]);

            Log::info('Sending invoice request to Xendit: ' . json_encode($create_invoice_request));

            $result = $apiInstance->createInvoice($create_invoice_request);

            Log::info('Invoice created successfully: ' . json_encode($result));

            $transactionData = [
                'external_id' => $external_id,
                'lesson_package_id' => $package->lesson_package_id,
                'user_id' => $user->user_id,
                'amount' => $package->lesson_package_price,
                'status' => 'pending', // Pastikan 'pending'
                'payer_email' => $request->email,
                'description' => $create_invoice_request->getDescription(),
                'invoice_url' => $result->getInvoiceUrl(),
            ];

            Log::info('Creating transaction with data: ' . json_encode($transactionData));

            $transaction = Transaction::create($transactionData);

            Log::info('Transaction created with ID: ' . $transaction->transaction_id);

            $invoiceData = [
                'external_id' => $external_id,
                'xendit_invoice_id' => $result->getId(),
                'transaction_id' => $transaction->transaction_id,
                'user_id' => $user->user_id,
                'lesson_package_id' => $package->lesson_package_id,
                'amount' => $package->lesson_package_price,
                'payer_email' => $request->email,
                'description' => $create_invoice_request->getDescription(),
                'status' => 'pending',
                'invoice_url' => $result->getInvoiceUrl(),
                'expires_at' => $result->getExpiryDate(),
            ];

            Log::info('Creating invoice with data: ' . json_encode($invoiceData));

            $invoice = Invoice::create($invoiceData);

            if (!$request->wantsJson()) {
                return redirect($result->getInvoiceUrl());
            }

            return response()->json([
                'message' => 'Invoice created successfully',
                'invoice_url' => $result->getInvoiceUrl(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating invoice: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            if (!$request->wantsJson()) {
                return redirect()->back()->with('error', 'Error creating invoice: ' . $e->getMessage());
            }

            return response()->json([
                'message' => 'Error creating invoice',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function handleWebhook(Request $request)
    {
        try {
            // Log seluruh data webhook untuk debugging
            Log::info('Webhook received with data: ' . json_encode($request->all()));

            // Verifikasi tanda tangan webhook (opsional, tetapi direkomendasikan)
            $xenditWebhookToken = config('services.xendit.webhook_token');
            $signature = $request->header('x-webhook-signature');
            if (!hash_equals(hash_hmac('sha256', $request->getContent(), $xenditWebhookToken), $signature)) {
                Log::error('Invalid webhook signature');
                return response()->json(['message' => 'Invalid webhook signature'], 403);
            }

            $data = $request->all();
            $external_id = $data['external_id'] ?? null;
            $status = isset($data['status']) ? strtolower($data['status']) : null;
            $payment_method = $data['payment_method'] ?? null;

            if (!$external_id || !$status) {
                Log::error('Webhook missing external_id or status', ['data' => $data]);
                return response()->json(['message' => 'Missing external_id or status'], 400);
            }

            // Perbarui status transaksi
            $transaction = Transaction::where('external_id', $external_id)->first();
            if ($transaction) {
                $transaction->status = $status;
                $transaction->payment_method = $payment_method;
                $transaction->save();
                Log::info('Transaction updated: ' . $transaction->transaction_id);
            } else {
                Log::warning('Transaction not found for external_id: ' . $external_id);
            }

            // Perbarui status invoice dan buat log keuangan
            $invoice = Invoice::where('external_id', $external_id)->first();
            if ($invoice) {
                $invoice->status = $status;
                $invoice->save();
                Log::info('Invoice updated: ' . $invoice->invoice_id);

                if ($status === 'paid' && !$invoice->financialLog()->exists()) {
                    Log::info('Preparing to create FinancialLog for invoice: ' . $invoice->invoice_id);

                    $financialLogData = [
                        'invoice_id' => $invoice->invoice_id,
                        'transaction_id' => $invoice->transaction_id,
                        'user_id' => $invoice->user_id,
                        'lesson_package_id' => $invoice->lesson_package_id,
                        'amount' => $invoice->amount,
                        'financial_type' => 'income',
                        'payment_method' => $payment_method,
                        'description' => 'Pembayaran untuk paket ' . ($invoice->lessonPackage->lesson_package_name ?? 'Unknown Package'),
                        'transaction_date' => now(),
                    ];

                    Log::info('Creating FinancialLog with data: ' . json_encode($financialLogData));

                    FinancialLog::create($financialLogData);
                    Log::info('FinancialLog created for invoice: ' . $invoice->invoice_id);
                } else {
                    Log::info('FinancialLog not created. Status: ' . $status . ', Exists: ' . ($invoice->financialLog()->exists() ? 'Yes' : 'No'));
                }
            } else {
                Log::warning('Invoice not found for external_id: ' . $external_id);
            }

            return response()->json([
                'message' => 'Webhook diterima',
                'status' => $status,
            ]);
        } catch (\Exception $e) {
            Log::error('Error memproses webhook: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'message' => 'Error memproses webhook',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function success(Request $request)
    {
        $invoice = Invoice::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
        return view('transaction.success', compact('invoice'));
    }

    public function failed()
    {
        return view('failed');
    }

    // public function financialReport()
    // {
    //     $logs = LogKeuangan::with(['user', 'lessonPackage'])->orderBy('transaction_date', 'desc')->get();
    //     return view('report', compact('logs'));
    // }


    // history invoice profile
    public function invoiceHistory()
    {
        $invoices = Invoice::where('user_id', Auth::id())->with('lessonPackage')->get();
        return view('profile.history', compact('invoices'));
    }
}
