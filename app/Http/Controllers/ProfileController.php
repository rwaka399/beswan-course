<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the profile page.
     */
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Show the edit profile form.
     */
    public function edit()
    {
        $provinces = json_decode(file_get_contents('https://ibnux.github.io/data-indonesia/provinsi.json'), true);
        return view('profile.edit', compact('provinces'));
    }

    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'password' => 'nullable|string|min:8',
            'phone_number' => 'nullable|string|max:20',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'province' => $request->province,
                'city' => $request->city,
                'kecamatan' => $request->kecamatan,
                'address' => $request->address,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            DB::commit();
            return redirect()->route('profile-index')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memperbarui profil.');
        }
    }
}