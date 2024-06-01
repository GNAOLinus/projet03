<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin de base',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'phone' => fake()->unique()->phoneNumber(),
            'password' => Hash::make('123456789'),
            'id_role' => 1, // Assuming '1' corresponds to the 'admin' role in your roles table
            'remember_token' => Str::random(10),
        ]);
    }
}

