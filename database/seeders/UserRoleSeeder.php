<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            'Admin' => 'Super Admin',
            'Guru' => 'Guru',
            'User' => 'User',
        ];

        foreach ($users as $userName => $roleName) {
            $user = User::where('name', $userName)->first();
            $role = Role::where('role_name', $roleName)->first();

            $user->userRole()->create([
                'role_id' => $role->role_id,
            ]);
        }
    }
}
