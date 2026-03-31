<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone_number' => '08' . $this->faker->numerify('##########'),
            'role' => 'user',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Create an admin user with specific credentials.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Admin NexStock',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'phone_number' => '08123456789',
                'id_admin' => 'ADM001',
                'role' => 'admin',
            ];
        });
    }

    /**
     * Create a regular user with specific credentials.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function regularUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'User Regular',
                'email' => 'user@gmail.com',
                'password' => Hash::make('user123'),
                'phone_number' => '081298765432',
                'role' => 'user',
            ];
        });
    }
}
