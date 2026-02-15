<?php

namespace App\Repositories\Contracts;

use App\Models\SiteSettings;

interface SiteSettingsRepositoryInterface
{
    public function get(): SiteSettings;

    public function update($data): void;
}
