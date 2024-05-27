<?php

namespace Database\Factories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AdminfactoryFactory extends Factory
{
     /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Admin de base',
            'email' => 'admi@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('123456789'),
            'remember_token' => Str::random(10),
        ];
    }
}
