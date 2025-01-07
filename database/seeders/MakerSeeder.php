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

        foreach ($makers as $maker) {
            $imageMaker = Image::query()->where('image_title', $maker)->first();
            if ($imageMaker) {
                Maker::factory()->create([
                    'name' => $maker,
                    'image_id' => $imageMaker->id
                ]);
            } else {
                $imageStub = Image::query()->where('image_title', 'car_stub')->first();
                Maker::factory()->create([
                    'name' => $maker,
                    'image_id' => $imageStub->id
                ]);
            }
        }
    }
}
