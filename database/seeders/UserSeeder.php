<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'          => 'Admin',
            'email'         => 'admin@gmail.com',
            'password'      => Hash::make('admin123'),
            'phone_number'  => '08123456789',
            'address'       => 'jl.rambutan'
        ]);
        User::create([
            'name'          => 'Guru',
            'email'         => 'guru@gmail.com',
            'password'      => Hash::make('admin123'),
            'phone_number'  => '08123456789',
            'address'       => 'jl.mangga'
        ]);
        User::create([
            'name'          => 'User',
            'email'         => 'user@gmail.com',
            'password'      => Hash::make('admin123'),   
            'phone_number'  => '08123456789',
            'address'       => 'jl.durian'
        ]);
    }
}
