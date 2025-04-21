<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        Role::create([
            'role_name'         => 'Super Admin',
            'role_description'  => 'Role ini bertindak sebagai Super Admin',
            'created_by'        => $admin->user_id,
            'updated_by'        => $admin->user_id,
        ]);
        Role::create([
            'role_name'         => 'Guru',
            'role_description'  => 'Role ini bertindak sebagai Guru',
            'created_by'        => $admin->user_id,
            'updated_by'        => $admin->user_id,
        ]);
        Role::create([
            'role_name'         => 'User',
            'role_description'  => 'Role ini bertindak sebagai User',
            'created_by'        => $admin->user_id,
            'updated_by'        => $admin->user_id,
        ]);
    }
}
