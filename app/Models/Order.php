<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const CACHE_KEY = 'order_items';
    public const CURRENT_CACHE_KEY = 'order_items_for_current';
    public const CACHE_TIME = 10;

    public $timestamps = false;

    protected $fillable = [
        'code',
        'city',
        'first_name',
        'last_name',
        'phone',
        'email',
        'price',
        'created_at',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transport(): BelongsTo
    {
        return $this->belongsTo(Transport::class);
    }

    public function orderTransports(): HasMany
    {
        return $this->hasMany(OrderTransport::class);
    }
}
