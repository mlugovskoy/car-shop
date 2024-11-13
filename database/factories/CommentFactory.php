<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "city" => $this->faker->city(),
            "description" => $this->faker->text(50),
            "user_id" => $this->faker->numberBetween(1, User::query()->count()),
            "published_at" => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
