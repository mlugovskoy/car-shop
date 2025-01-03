<?php

namespace App\Http\Requests\Transports;

use Illuminate\Foundation\Http\FormRequest;

class TransportsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'makers' => ['nullable', 'string'],
            'models' => ['nullable', 'string'],
            'transmission' => ['nullable', 'string'],
            'drive' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
            'fuelType' => ['nullable', 'string'],
            'transportType' => ['nullable', 'string'],
            'year.min' => ['nullable', 'string'],
            'year.max' => ['nullable', 'string'],
            'price.min' => ['nullable', 'numeric'],
            'price.max' => ['nullable', 'numeric'],
            'steeringWheel' => ['nullable', 'string']
        ];
    }
}
