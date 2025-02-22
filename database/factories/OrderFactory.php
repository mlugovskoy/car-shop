<?php

namespace Database\Factories;

use App\Models\Transport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "code" => Str::random(),
            "city" => $this->faker->city(),
            "phone" => $this->faker->phoneNumber(),
            "email" => $this->faker->email(),
            "price" => $this->faker->randomNumber(),
            "user_id" => $this->faker->numberBetween(1, User::query()->count()),
        ];
    }
}
