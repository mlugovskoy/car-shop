<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maker extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'image_id'];

    public function images(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'image_maker');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function transports()
    {
        return $this->hasMany(Transport::class);
    }

    public function models()
    {
        return $this->hasMany(Model::class);
    }
}
