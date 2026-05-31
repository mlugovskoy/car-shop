<?php

namespace Database\Factories;

use App\Models\Maker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Camry', 'Corolla', 'X5', 'X6', 'C-Class',
                'E-Class', 'Rio', 'Qashqai', 'CR-V', 'Mazda6'
            ]),
            'maker_id' => Maker::query()->inRandomOrder()->value('id'),
        ];
    }
}
