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
        $maker = Maker::query()->inRandomOrder()->first();
        $model = Model::query()->where('maker_id', $maker->id)->inRandomOrder()->first();

        return [
            "active" => $this->faker->boolean,
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
            "user_id" => User::query()->inRandomOrder()->value('id'),
            'maker_id' => $maker->id,
            'model_id' => $model->id,
            'fuel_type_id' => FuelType::query()->inRandomOrder()->value('id'),
            'transport_type_id' => TransportType::query()->inRandomOrder()->value('id'),
            "published_at" => $this->faker->dateTimeBetween('-3 month', 'now'),
        ];
    }
}
