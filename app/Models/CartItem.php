<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    public const CACHE_KEY = 'cart_items';
    public const CACHE_TIME = 10;

    protected $fillable = [
        'code',
        'user_id',
        'transport_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }
}
