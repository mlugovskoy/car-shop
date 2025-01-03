<?php

namespace App\Http\Requests\Transports;

use Illuminate\Foundation\Http\FormRequest;

class TransportsCreateRequest extends FormRequest
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
            'city' => ['max:100', 'string', 'nullable'],
            'vin' => ['max:100', 'string', 'nullable'],
            'phone' => ['max:50', 'numeric', 'nullable'],
            'description' => ['max:1000', 'string', 'nullable'],
            'engine' => ['max:100', 'string', 'nullable'],
            'power' => ['max:100', 'numeric', 'nullable'],
            'mileage' => ['max:100', 'numeric', 'nullable'],
            'color' => ['max:100', 'string', 'nullable'],
            'steering_wheel' => ['max:100', 'string', 'nullable'],
            'country' => ['max:100', 'string', 'nullable'],
            'tact' => ['max:100', 'string', 'nullable'],
            'fuel_supply_type' => ['max:100', 'string', 'nullable'],
            'doors' => ['max:100', 'numeric', 'nullable'],
            'seats' => ['max:100', 'numeric', 'nullable'],
            'year' => ['max:100', 'numeric', 'nullable'],
            'price' => ['required', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения.',
            'max' => 'Вы превысили лимит символов для поля :attribute',
            'string' => 'Поле :attribute должно быть типа строка',
            'numeric' => 'Поле :attribute должно быть типа число',
        ];
    }

    public function attributes(): array
    {
        return [
            'makers' => 'Марка',
            'models' => 'Модель',
            'transmission' => 'Трансмиссия',
            'city' => 'Город',
            'vin' => 'Vin',
            'phone' => 'Телефон',
            'description' => 'Описание',
            'engine' => 'Двигатель',
            'power' => 'Мощность',
            'drive' => 'Привод',
            'mileage' => 'Пробег',
            'color' => 'Цвет',
            'steering_wheel' => 'Руль',
            'country' => 'Страна',
            'tact' => 'Такт двигателя',
            'fuel_supply_type' => 'Система подачи топлива',
            'doors' => 'Количество дверей',
            'seats' => 'Количество мест',
            'year' => 'Год',
            'fuel_type_id' => 'Тип топлива',
            'transport_type_id' => 'Тип транспорта',
            'price' => 'Цена',
        ];
    }
}
