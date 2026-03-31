<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin user
        User::create([
            'name' => 'Admin NexStock',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'phone_number' => '08123456789',
            'id_admin' => 'ADM001',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Regular User
        User::create([
            'name' => 'User Regular',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user123'),
            'phone_number' => '081298765432',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }
}
