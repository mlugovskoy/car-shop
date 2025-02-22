<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'firstName' => ['max:100', 'string'],
            'lastName' => ['max:100', 'string'],
            'city' => ['max:100', 'string', 'required'],
            'email' => ['max:100', 'string', 'required'],
            'phone' => ['max:45', 'string', 'required'],
            'price' => ['string', 'min:1', 'required']
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения.',
            'max' => 'Вы превысили лимит символов для поля :attribute',
            'min' => 'Минимальное количество символов для поля :attribute = 1',
            'string' => 'Поле :attribute должно быть типа строка',
        ];
    }

    public function attributes(): array
    {
        return [
            'firstName' => 'Имя',
            'lastName' => 'Фамилия',
            'city' => 'Город',
            'email' => 'Почта',
            'phone' => 'Телефон',
            'price' => 'Цена'
        ];
    }
}
