<?php

namespace Database\Factories;

use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\TransportType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transport>
 */
class TransportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "city" => $this->faker->city,
            "vin" => $this->faker->numberBetween(10000000, 99999999),
            "phone" => $this->faker->phoneNumber,
            "description" => $this->faker->text(),
            "engine" => $this->faker->sentence(1),
            "power" => $this->faker->numberBetween(1000, 99999),
            "transmission" => $this->faker->randomElement(['Вариантор', 'Автомат', 'Механика']),
            "drive" => $this->faker->randomElement(['Передний', 'Задний']),
            "mileage" => $this->faker->numberBetween(1000, 99999),
            "color" => $this->faker->colorName(),
            "steering_wheel" => $this->faker->randomElement(['Правый', 'Левый']),
            "country" => $this->faker->country(),
            "tact" => $this->faker->numberBetween(1000, 99999),
            "fuel_supply_type" => $this->faker->randomElement(['Карбюратор', 'Инжектор']),
            "doors" => $this->faker->numberBetween(1, 6),
            "seats" => $this->faker->numberBetween(1, 24),
            "price" => $this->faker->numberBetween(100000, 10000000),
            "year" => $this->faker->year,
            "user_id" => $this->faker->numberBetween(1, User::query()->count()),
            "model_id" => $this->faker->numberBetween(1, Model::query()->count()),
            "maker_id" => $this->faker->numberBetween(1, Maker::query()->count()),
            "fuel_type_id" => $this->faker->numberBetween(1, FuelType::query()->count()),
            "transport_type_id" => $this->faker->numberBetween(1, TransportType::query()->count()),
            "published_at" => $this->faker->dateTimeBetween('-3 month', 'now'),
        ];
    }
}
