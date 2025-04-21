<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:255|unique:roles',
            'role_description' => 'required|string|max:255',
        ]);


        DB::beginTransaction();
        try {
            Role::create([
                'role_name' => $request->role_name,
                'role_description' => $request->role_description,
                'created_by' => Auth::user()->user_id,
            ]);

            DB::commit();

            return redirect()->route('role-index')->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create role.');
        }
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return view('admin.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required|string|max:255|unique:roles,role_name,' . $id . ',role_id',
            'role_description' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            Role::where('role_id', $id)->update([
                'role_name'         => $request->role_name,
                'role_description'  => $request->role_description,
                'updated_at'        => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by'        => Auth::user()->user_id,
            ]);

            DB::commit();
            return redirect()->route('role-index')->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update role.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        DB::beginTransaction();
        try {
            $role->delete();

            DB::commit();

            return redirect()->route('role-index')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete role.');
        }
        return redirect()->route('admin.role.index')->with('success', 'Role deleted successfully.');
    }
}
