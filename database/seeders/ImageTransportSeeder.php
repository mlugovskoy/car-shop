<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Transport;
use Illuminate\Database\Seeder;

class ImageTransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transports = Transport::all();
        $images = Image::query()->where('image_source', 'transports')->get();

        foreach ($transports as $transport) {
            $randomImages = $images->random(rand(1, 5));

            $transport->images()->attach($randomImages);
        }
    }
}
