<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@minglanilla.gov.ph',
            'role' => 'admin',
            'password' => Hash::make(env('ADMIN_PASSWORD','password')),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create MITCOM Officer
        User::create([
            'first_name' => 'MITCOM',
            'last_name' => 'Officer',
            'email' => 'mitcom@minglanilla.gov.ph',
            'role' => 'mitcom',
            'password' => Hash::make(env('MITCOM_PASSWORD','password')),
            'email_verified_at' => now(),
        ]);

        // Create Regular User
        User::create([
            'first_name' => 'Regular',
            'last_name' => 'User',
            'email' => 'user@example.com',
            'role' => 'user',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $this->command->info('Created 3 test users successfully!');
        $this->command->info('Admin: admin@minglanilla.gov.ph / password');
        $this->command->info('MITCOM: mitcom@minglanilla.gov.ph / password');
        $this->command->info('User: user@example.com / password');
    }
}