<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'year',
        'grade',
        'engine',
        'power',
        'description',
        'transmission',
        'drive',
        'mileage',
        'tact',
        'user_id',
        'model_id',
        'maker_id',
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function images(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'image_review');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'comment_review');
    }
}
