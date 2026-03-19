<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'kannan.webzschema@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '1234567890',
            'address' => 'RuralEmpower HQ',
        ]);

        // Regular User
        User::create([
            'name' => 'Regular User',
            'email' => 'user@ruralempower.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '0987654321',
            'address' => 'Village A, India',
        ]);

        // Also ensure the default test user has a known password if it exists or create it
        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser) {
            $testUser->update([
                'password' => Hash::make('password123'),
                'role' => 'user'
            ]);
        }
    }
}
