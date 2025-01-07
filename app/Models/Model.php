<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Model extends EloquentModel
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'maker_id'];

    public function maker(): BelongsTo
    {
        return $this->belongsTo(Maker::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function transports()
    {
        return $this->hasMany(Transport::class);
    }
}
