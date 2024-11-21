<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;

class ImageUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $images = Image::query()->where('image_source', 'users')->get();

        foreach ($users as $user) {
            $randomImage = $images->random();

            $user->images()->attach($randomImage);
        }
    }
}
