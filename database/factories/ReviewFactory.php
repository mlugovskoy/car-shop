<?php

namespace Database\Factories;

use App\Models\Maker;
use App\Models\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => $this->faker->year(),
            'grade' => $this->faker->randomFloat(0, 5),
            "engine" => $this->faker->sentence(1),
            "power" => $this->faker->numberBetween(1000, 99999),
            "transmission" => $this->faker->randomElement(['Вариантор', 'Автомат', 'Механика']),
            "drive" => $this->faker->randomElement(['Передний', 'Задний']),
            "mileage" => $this->faker->numberBetween(1000, 99999),
            "tact" => $this->faker->numberBetween(1000, 99999),
            "description" => $this->faker->text(),
            "user_id" => User::query()->inRandomOrder()->value('id'),
            "model_id" => Model::query()->inRandomOrder()->value('id'),
            "maker_id" => Maker::query()->inRandomOrder()->value('id'),
            "published_at" => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
