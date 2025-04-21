<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
        ]);

        try {

            $email = strtolower($request->email);


            $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

            // Cek user & password cocok
            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user, $request->has('remember'));

                // Ambil role pertama user
                $userRole = $user->userRole->first();

                if (!$userRole) {
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'User does not have a role assigned.');
                }

                // Simpan role & user_id ke session
                Session::put([
                    'role_id' => $userRole->role_id,
                    'user_id' => $user->user_id,
                ]);

                return redirect()->intended('/')->with('success', 'Login successful! Welcome back.');
            }

            // Kalau kombinasi user dan password salah
            return redirect()->route('login')->with('error', 'Invalid email or password.');
        } catch (\Throwable $e) {
            Log::error('Login gagal', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('login')->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function register()
    {
        $response = Http::get('https://ibnux.github.io/data-indonesia/provinsi.json');
        if ($response->failed()) {
            Log::error('Gagal mengambil data provinsi dari API');
            return view('auth.register', ['provinces' => []])->with('error', 'Failed to load provinces. Please try again later.');
        }

        $provinces = $response->json();
        return view('auth.register', compact('provinces'));
    }

    public function registerPost(Request $request)
    {
        // Debugging: Cetak data yang diterima
        Log::info('Data registrasi:', $request->all());

        // Validasi input dengan aturan tambahan
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required|string|max:15|regex:/^\+?[1-9]\d{1,14}$/',
            'province' => 'required|string|max:100|not_in:Pilih Provinsi',
            'city' => 'required|string|max:100|not_in:Pilih Kota',
            'kecamatan' => 'required|string|max:100|not_in:Pilih Kecamatan',
            'address' => 'required|string|max:500',
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
            'phone_number.regex' => 'The phone number format is invalid (e.g., +628123456789).',
            'province.not_in' => 'Please select a valid province.',
            'city.not_in' => 'Please select a valid city.',
            'kecamatan.not_in' => 'Please select a valid district.',
        ]);

        DB::beginTransaction();

        try {
            // Membuat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'province' => $request->province,
                'city' => $request->city,
                'kecamatan' => $request->kecamatan,
                'address' => $request->address,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            // Ambil role 'User' dan assign ke user
            $role = Role::where('role_name', 'User')->first();
            if (!$role) {
                Log::error('Role User tidak ditemukan');
                throw new \Exception('Role User tidak ditemukan');
            }

            UserRole::create([
                'user_id' => $user->user_id,
                'role_id' => $role->role_id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            DB::commit();

            // Login dan set session
            Auth::login($user);
            Session::put([
                'role_id' => $user->userRole->first()->role_id,
                'user_id' => $user->user_id,
            ]);

            return redirect()->intended('/')->with('success', 'Registration successful! Welcome to the platform.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registrasi gagal: ' . $e->getMessage());
            return back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }
}
