<?php

namespace App\Services;

use App\Models\Maker;
use App\Models\News;
use App\Models\Review;
use App\Models\Transport;
use Carbon\Carbon;

class HomeService
{
    public function getTransportsInTopSlider(): \Illuminate\Database\Eloquent\Collection
    {
        $transports = Transport::query()
            ->orderBy('published_at', 'desc')
            ->limit(15)
            ->get(['id', 'city', 'model_id', 'maker_id', 'price']);


        foreach ($transports as $transport) {
            foreach ($transport->images as $image) {
                $transport->push($image);
            }

            $transport->makerName = $transport->maker->name;
            $transport->modelName = $transport->model->name;
        }

        return $transports;
    }

    public function getLatestReviews()
    {
        $reviews = Review::query()->orderBy('published_at', 'desc')
            ->limit(5)
            ->get(['id', 'published_at', 'model_id', 'maker_id', 'year']);

        foreach ($reviews as $review) {
            foreach ($review->images as $image) {
                $review->push($image);
            }
            foreach ($review->comments as $comment) {
                $review->push($comment);
            }

            $review->makerName = $review->maker->name;
            $review->modelName = $review->model->name;
            $review->published_at = Carbon::parse($review->published_at)->translatedFormat('d F');
        }

        return $reviews;
    }

    public function getLatestNews()
    {
        $news = News::query()->orderBy('published_at', 'desc')
            ->limit(5)
            ->get(['id', 'title', 'description', 'published_at']);

        foreach ($news as $article) {
            foreach ($article->images as $image) {
                $article->push($image);
            }
            foreach ($article->comments as $comment) {
                $article->push($comment);
            }

            $article->published_at = Carbon::parse($article->published_at)->translatedFormat('d F');
        }

        return $news;
    }

    public function getMakers()
    {
        $makers = Maker::all();

        foreach ($makers as $maker) {
            foreach ($maker->images as $image) {
                $maker->push($image);
            }
        }

        return $makers;
    }
}
