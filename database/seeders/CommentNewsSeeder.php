<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\News;
use Illuminate\Database\Seeder;

class CommentNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = News::all();
        $comments = Comment::all();

        foreach ($news as $newsItem) {
            $randomComments = $comments->random(rand(1, 5));

            $newsItem->comments()->attach($randomComments);
        }
    }
}
