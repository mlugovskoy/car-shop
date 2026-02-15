<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteSettingsUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'yandex_map' => ['max:2000', 'string', 'nullable'],
            'yandex_coords' => ['max:200', 'string', 'nullable'],
            'yandex_zoom' => ['max:2', 'string', 'nullable']
        ];
    }
}
