<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = User::with('userRole.role');

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(phone_number) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(province) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(city) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(kecamatan) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(address) LIKE ?', ["%{$search}%"])
                    ->orWhereHas('userRole.role', function ($r) use ($search) {
                        $r->whereRaw('LOWER(role_name) LIKE ?', ["%{$search}%"]);
                    });
            });
        }

        $users = $query->paginate(5)->appends(['search' => $request->search]);

        return view('master.user.index', compact('users'));
    }

    public function create()
    {
        $provinces = $this->fetchProvinces();
        $roles = Role::all();

        return view('master.user.create', compact('roles', 'provinces'));
    }

    public function store(Request $request)
    {
        $provinces = array_column($this->fetchProvinces(), 'nama');
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'nullable|string|min:6',
            'phone_number'  => 'required|string|max:15',
            'province'      => 'nullable|string|max:255|in:' . implode(',', $provinces),
            'city'          => 'nullable|string|max:255',
            'kecamatan'     => 'nullable|string|max:255',
            'address'       => 'required|string|max:255',
            'role_id'       => 'required|exists:roles,role_id',
        ]);

        DB::beginTransaction();

        try {
            $password = $request->filled('password') ? $request->password : 'admin123';

            $user = User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'password'      => Hash::make($password),
                'phone_number'  => $request->phone_number,
                'province'      => $request->province,
                'city'          => $request->city,
                'kecamatan'     => $request->kecamatan,
                'address'       => $request->address,
                'created_by'    => Auth::user()->user_id ?? null,
                'created_at'    => now(),
            ]);

            UserRole::create([
                'user_id'       => $user->user_id,
                'role_id'       => $request->role_id,
                'created_by'    => Auth::user()->user_id ?? null,
                'created_at'    => now(),
            ]);

            DB::commit();

            return redirect()->route('user-index')->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        // Ambil data user beserta relasi userRole
        $user = User::with('userRole')->findOrFail($id);

        // Ambil semua role
        $roles = Role::all();

        // Ambil data provinsi dari sumber eksternal
        $provinces = json_decode(file_get_contents('https://ibnux.github.io/data-indonesia/provinsi.json'), true);

        // Kirim data ke view
        return view('master.user.edit', compact('user', 'roles', 'provinces'));
    }

    public function update(Request $request, $id)
    {
        $provinces = array_column($this->fetchProvinces(), 'nama');
        $request->validate([
            'name'          => 'nullable|string|max:255',
            'email'         => 'nullable|email|unique:users,email,' . $id . ',user_id',
            'password'      => 'nullable|string|min:6',
            'phone_number'  => 'nullable|string|max:15',
            'province'      => 'nullable|string|max:255|in:' . implode(',', $provinces),
            'city'          => 'nullable|string|max:255',
            'kecamatan'     => 'nullable|string|max:255',
            'address'       => 'nullable|string|max:255',
            'role_id'       => 'nullable|exists:roles,role_id',
        ]);

        DB::beginTransaction();
        try {
            $fields = ['name', 'email', 'phone_number', 'province', 'city', 'kecamatan', 'address'];
            $updateUser = [];

            foreach ($fields as $field) {
                if ($request->filled($field)) {
                    $updateUser[$field] = $request->$field;
                }
            }

            if ($request->filled('password')) {
                $updateUser['password'] = Hash::make($request->password);
            }

            $updateUser['updated_at'] = now();
            $updateUser['updated_by'] = Auth::user()->user_id ?? null;

            User::where('user_id', $id)->update($updateUser);

            if ($request->filled('role_id')) {
                UserRole::updateOrCreate(
                    ['user_id' => $id],
                    [
                        'role_id'       => $request->role_id,
                        'updated_at'    => now(),
                        'updated_by'    => Auth::user()->user_id ?? null
                    ]
                );
            }

            DB::commit();
            return redirect()->route('user-index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Log::info("Attempting to delete user with ID: {$id}");
            UserRole::where('user_id', $id)->delete();
            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();
            return redirect()->route('user-index')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to delete user ID: {$id}, Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    private function fetchProvinces()
    {
        return Cache::remember('provinces', now()->addHours(24), function () {
            try {
                $response = Http::timeout(10)->get('https://ibnux.github.io/data-indonesia/provinsi.json');
                if ($response->successful()) {
                    return $response->json();
                }
                Log::error('Failed to fetch provinces', ['status' => $response->status()]);
                return [];
            } catch (\Exception $e) {
                Log::error('Error fetching provinces: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function getCities(Request $request)
    {
        $provinceId = $request->query('province_id');
        try {
            $url = "https://ibnux.github.io/data-indonesia/kota/{$provinceId}.json";
            Log::info('Fetching cities', ['province_id' => $provinceId, 'url' => $url]);
            $response = Http::timeout(10)->get($url);
            if ($response->successful()) {
                $cities = $response->json();
                Log::info('Cities fetched successfully', ['province_id' => $provinceId, 'city_count' => count($cities)]);
                return response()->json($cities);
            }
            Log::error('Failed to fetch cities', [
                'province_id' => $provinceId,
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return response()->json([], 500);
        } catch (\Exception $e) {
            Log::error('Error fetching cities: ' . $e->getMessage(), ['province_id' => $provinceId]);
            return response()->json([], 500);
        }
    }

    public function getKecamatan(Request $request)
    {
        $cityId = $request->query('city_id');
        try {
            $url = "https://ibnux.github.io/data-indonesia/kecamatan/{$cityId}.json";
            Log::info('Fetching kecamatan', ['city_id' => $cityId, 'url' => $url]);
            $response = Http::timeout(10)->get($url);
            if ($response->successful()) {
                $kecamatans = $response->json();
                Log::info('Kecamatans fetched successfully', ['city_id' => $cityId, 'kecamatan_count' => count($kecamatans)]);
                return response()->json($kecamatans);
            }
            Log::error('Failed to fetch kecamatan', [
                'city_id' => $cityId,
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return response()->json([], 500);
        } catch (\Exception $e) {
            Log::error('Error fetching kecamatan: ' . $e->getMessage(), ['city_id' => $cityId]);
            return response()->json([], 500);
        }
    }
}
