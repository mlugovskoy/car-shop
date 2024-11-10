<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'review_id' => $this->faker->numberBetween(1, Review::query()->count()),
            'comment_id' => $this->faker->numberBetween(1, Comment::query()->count()),
        ];
    }
}
