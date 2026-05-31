<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\News;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentNewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'review_id' => Review::query()->inRandomOrder()->value('id'),
            'comment_id' => Comment::query()->inRandomOrder()->value('id')
        ];
    }
}
