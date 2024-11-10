<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ImageReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = Review::all();
        $images = Image::all();

        foreach ($reviews as $review) {
            $randomImages = $images->random(rand(1, 5));

            $review->images()->attach($randomImages);
        }
    }
}
