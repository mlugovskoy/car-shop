<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SiteSettings extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'site.settings';
    }
}
