<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ImageTransportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transport_id' => $this->faker->numberBetween(1, Transport::query()->count()),
            'image_id' => $this->faker->numberBetween(1, Image::query()->count()),
        ];
    }
}
