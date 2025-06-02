<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@freedomtrack.ng',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Correctional Officer',
                'email' => 'officer@freedomtrack.ng',
                'password' => Hash::make('password'),
                'role' => 'correctional',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Judge Adebayo',
                'email' => 'judge@freedomtrack.ng',
                'password' => Hash::make('password'),
                'role' => 'judiciary',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'NGO Coordinator',
                'email' => 'ngo@freedomtrack.ng',
                'password' => Hash::make('password'),
                'role' => 'ngo',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Research Analyst',
                'email' => 'researcher@freedomtrack.ng',
                'password' => Hash::make('password'),
                'role' => 'researcher',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
