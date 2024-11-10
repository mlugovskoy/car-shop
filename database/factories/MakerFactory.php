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
            'name' => $this->faker->sentence(),
            'image_id' => $this->faker->numberBetween(1, Image::query()->count()),
        ];
    }
}
