<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = Review::all();
        $comments = Comment::all();

        foreach ($reviews as $review) {
            $randomComments = $comments->random(rand(1, 5));

            $review->comments()->attach($randomComments);
        }
    }
}
