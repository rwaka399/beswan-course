<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Berhasil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4 py-10">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl p-8 text-center">
        <div class="mb-6">
            <svg class="mx-auto w-16 h-16 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5" 
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            <h1 class="text-3xl font-bold text-gray-800 mt-4">Transaksi Berhasil!</h1>
            <p class="text-gray-600 mt-2">Terima kasih atas pembayaran Anda.</p>
        </div>

        @if ($invoice)
        <div class="bg-gray-50 p-6 rounded-lg text-left space-y-3 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700">Detail Invoice</h3>
            <p><span class="font-semibold">Nomor Invoice:</span> {{ $invoice->external_id }}</p>
            <p><span class="font-semibold">Paket:</span> {{ $invoice->lessonPackage->lesson_package_name }}</p>
            <p><span class="font-semibold">Jumlah:</span> Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
            <p><span class="font-semibold">Status:</span> 
                <span class="inline-block px-2 py-1 rounded bg-green-100 text-green-700 text-sm capitalize">
                    {{ $invoice->status }}
                </span>
            </p>
            <p><span class="font-semibold">Tanggal:</span> {{ $invoice->created_at->format('d M Y H:i') }}</p>
        </div>
        @endif

        <a href="{{ url('/') }}" 
           class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            Kembali ke Beranda
        </a>
    </div>

</body>
</html>
