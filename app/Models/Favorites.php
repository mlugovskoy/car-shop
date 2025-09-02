<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    use HasFactory;

    public const CACHE_KEY = 'favorites_items';
    public const CACHE_TIME = 10;

    protected $fillable = [
        'user_id',
        'transport_id',
    ];
}
