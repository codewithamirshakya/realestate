<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@omrealtors.com.np'],
            [
                'name' => 'Sanjay Maharjan',
                'phone' => '9841000000',
                'role' => User::ROLE_ADMIN,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'agent@omrealtors.com.np'],
            [
                'name' => 'Om Realtors Agent',
                'phone' => '9841000001',
                'role' => User::ROLE_AGENT,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'buyer@example.com'],
            [
                'name' => 'Demo Buyer',
                'phone' => '9841000002',
                'role' => User::ROLE_BUYER,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // A handful of extra agents so admin/property listings have variety.
        User::factory()->agent()->count(3)->create();
    }
}
