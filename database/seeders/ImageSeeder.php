<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $folders = ['images/icons', 'images/reviews', 'images/cars', 'images/stub'];

        foreach ($folders as $folder) {
            $sourcePath = public_path($folder);
            $images = scandir($sourcePath);

            foreach ($images as $image) {
                if ($image !== '.' && $image !== '..') {
                    $imagePath = $sourcePath . '/' . $image;

                    $fileSize = filesize($imagePath);
                    $fileExtension = pathinfo($imagePath, PATHINFO_EXTENSION);

                    $filePath = Storage::putFileAs($folder, new File($imagePath), $image);

                    Image::factory()->create([
                        'image_title' => explode('.', $image)[0],
                        'image_path' => $filePath,
                        'image_size' => $fileSize,
                        'image_ext' => $fileExtension,
                    ]);
                }
            }
        }
    }
}
