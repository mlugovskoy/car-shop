<?php

namespace Database\Factories;

use App\Models\Transport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            "code" => $this->faker->text(16),
            "quantity" => $this->faker->randomDigit(),
            "city" => $this->faker->city(),
            "phone" => $this->faker->phoneNumber(),
            "email" => $this->faker->email(),
            "price" => $this->faker->randomNumber(),
            "user_id" => $this->faker->numberBetween(1, User::query()->count()),
            "transport_id" => $this->faker->numberBetween(1, Transport::query()->count()),
        ];
    }
}
