<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Maker;
use Illuminate\Database\Seeder;

class ImageMakersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makers = Maker::all();
        $images = Image::query()->where('image_source', 'icons')->get();

        foreach ($makers as $maker) {
            $randomImages = $images->random();

            $maker->images()->attach($randomImages);
        }
    }
}
