<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makers extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'image_id'];
}
