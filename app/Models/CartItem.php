<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'code',
        'user_id',
        'transport_id',
    ];

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }
}
