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
    protected static ?string $password;

    public function definition(): array
    {
        $name = fake()->unique()->name();

        return [
            'name'           => $name,
            'name_key'       => Str::lower($name),
            'password'       => static::$password ??= Hash::make('password123'),
            'remember_token' => Str::random(10),
        ];
    }
}