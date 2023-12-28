<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'first_name'=> fake()->name('male'),
            'last_name'=>fake()->lastName,
            'age'=>fake()->numberBetween(18 , 50),
            'gender'=>fake()->randomElement(['male' , 'female']),
            'phone_number'=>fake()->phoneNumber(),
            'address'=>fake()->address,
            'post_code'=>fake()->postcode,
            'province'=>fake()->city,
            'city'=>fake()->city,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */

}
