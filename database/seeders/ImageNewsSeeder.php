<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\News;
use Illuminate\Database\Seeder;

class ImageNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = News::all();
        $images = Image::query()->where('image_source', 'news')->get();

        foreach ($news as $newsItem) {
            $randomImages = $images->random(rand(1, 5));

            $newsItem->images()->attach($randomImages);
        }
    }
}
