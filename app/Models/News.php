<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const CACHE_KEY = 'maker_items';
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

    public function images(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'image_news');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'comment_news');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
