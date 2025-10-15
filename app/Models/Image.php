<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Image extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['image_title', 'image_path', 'image_size', 'image_ext', 'image_source'];

    public function makers(): BelongsTo
    {
        return $this->belongsTo(Maker::class, 'image_maker');
    }

    public function transport(): BelongsTo
    {
        return $this->belongsTo(Transport::class, 'image_transport');
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class, 'image_review');
    }

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class, 'image_news');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'image_user');
    }
}
