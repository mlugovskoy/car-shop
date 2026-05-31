<?php

namespace Database\Factories;

use App\Models\Maker;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MakerFactory extends Factory
{
    protected $model = Maker::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Toyota', 'BMW', 'Mercedes', 'Audi',
                'Honda', 'Nissan', 'Mazda', 'Kia', 'Lada'
            ]),
            'image_id' => Image::query()->inRandomOrder()->value('id'),
        ];
    }
}
