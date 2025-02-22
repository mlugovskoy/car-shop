<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTransport extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'transport_id',
    ];

    protected function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
