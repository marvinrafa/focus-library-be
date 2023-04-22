<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            [
                'email' => 'librarian@test.com',
            ],
        [
            'first_name' => 'First Name',
            'last_name' => 'Last name',
            'email_verified_at' => now(),
            'password' => '1234',
            'role' => 'librarian'
        ]);

        User::firstOrCreate(
            [
                'email' => 'student@test.com',
            ],
        [
            'first_name' => 'Student First Name',
            'last_name' => 'Student Last name',
            'email_verified_at' => now(),
            'password' => '1234',
            'role' => 'student'
        ]);
    }
}
