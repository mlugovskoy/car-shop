<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Maker;
use Illuminate\Database\Seeder;

class MakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makers = [
            'BMW',
            'Mercedes-Benz',
            'Honda',
            'Hyundai',
            'Changan',
            'Mazda',
            'Suzuki',
            'Toyota',
            'Nissan',
            'Subaru',
            'Lexus',
            'Ford',
            'Лада',
            'УАЗ',
            'Daithatsu',
            'Isuzu',
            'Kia'
        ];

        $stub = Image::query()->where('image_title', 'car_stub')->firstOrFail();

        foreach ($makers as $maker) {
            $image = Image::query()->where('image_title', $maker)->first();

            Maker::query()->create([
                'name'     => $maker,
                'image_id' => $image?->id ?? $stub->id
            ]);
        }
    }
}
