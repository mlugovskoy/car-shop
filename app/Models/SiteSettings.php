<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class SiteSettings extends EloquentModel
{
    public const CACHE_KEY = 'site_settings';
    public const CACHE_TIME = 10;

    public $timestamps = false;

    protected $fillable = [
        'yandex_map',
        'yandex_coords',
        'yandex_zoom'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (static::count() > 0) {
                throw new \Exception('Нельзя пересоздать настройки сайта');
            }
        });
    }
}
