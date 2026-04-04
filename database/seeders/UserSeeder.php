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
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create MITCOM Officer
        User::create([
            'first_name' => 'Enforcer',
            'last_name' => 'Bas',
            'email' => 'enforcer@minglanilla.gov.ph',
            'role' => 'enforcer',
            'password' => Hash::make('password'),
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
        //Create Head MITCOM
        User::create([
            'first_name' => 'Head',
            'last_name' => 'MITCOM',
            'email' => 'headmitcom@minglanilla.gov.ph',
            'role' => 'head-mitcom',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        // Additional Enforcers
        User::create([
            'first_name' => 'Marco',
            'last_name' => 'Reyes',
            'email' => 'enforcer2@minglanilla.gov.ph',
            'role' => 'enforcer',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Dana',
            'last_name' => 'Villanueva',
            'email' => 'enforcer3@minglanilla.gov.ph',
            'role' => 'enforcer',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Additional Citizens
        User::create([
            'first_name' => 'Juan',
            'last_name' => 'dela Cruz',
            'email' => 'juan@example.com',
            'role' => 'user',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'email' => 'maria@example.com',
            'role' => 'user',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $this->command->info('Created 3 test users successfully!');
        $this->command->info('Admin: admin@minglanilla.gov.ph / password');
        $this->command->info('Enforcer: enforcer@minglanilla.gov.ph / password');
        $this->command->info('User: user@example.com / password');
        $this->command->info('Head MITCOM: headmitcom@minglanilla.gov.ph / password');
    }
}