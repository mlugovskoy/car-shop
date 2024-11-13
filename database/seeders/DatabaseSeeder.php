<?php

namespace Database\Seeders;

use App\Models\Notifications;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ImageSeeder::class,
            MakerSeeder::class,
            ModelSeeder::class,
            FuelTypeSeeder::class,
            TransportTypeSeeder::class,
            TransportSeeder::class,
            ImageTransportSeeder::class,
            ReviewSeeder::class,
            CommentSeeder::class,
            CommentReviewSeeder::class,
            ImageReviewSeeder::class,
            NewsSeeder::class,
            CommentNewsSeeder::class,
            ImageNewsSeeder::class,
            FavoritesSeeder::class,
            NotificationsSeeder::class
        ]);
    }
}
