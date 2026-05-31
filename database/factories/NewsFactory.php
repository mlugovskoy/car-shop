<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "active" => $this->faker->boolean,
            "title" => $this->faker->sentence(),
            "description" => $this->faker->text(),
            "user_id" => User::query()->inRandomOrder()->value('id'),
            "published_at" => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
