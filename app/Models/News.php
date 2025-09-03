<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const CACHE_KEY = 'news_items';
    public const HOME_CACHE_KEY = 'home_news_items';
    public const ADMIN_CACHE_KEY = 'admin_news_items';
    public const DETAIL_CACHE_KEY = 'news_item_detail';
    public const CACHE_TIME = 10;

    protected $fillable = [
        'id',
        'active',
        'title',
        'description',
        'user_id',
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'image_news');
    }

    public function comments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'comment_news');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
