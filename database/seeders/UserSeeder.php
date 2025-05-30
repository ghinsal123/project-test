<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Membuat data agent
        User::updateOrCreate(
            ['email' => 'agent@example.com'],
            [
                'name' => 'Agent Satu',
                'password' => Hash::make('secret123'),
                'role' => 'agent',
                'email_verified_at' => now(), // opsional, supaya email langsung verified
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Membuat data user biasa
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User Biasa',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
