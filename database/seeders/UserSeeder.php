<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's admin user.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Angel Faith Ibasco',
            'email' => 'admin@optiq.com',
            'password' => 'password', // auto-hashed by User model's `casts` method
        ]);
    }
}
