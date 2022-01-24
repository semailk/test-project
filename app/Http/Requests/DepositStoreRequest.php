<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepositStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'client_id' => [
                'required',
                'numeric',
                Rule::exists('clients', 'id'),
            ],
            'value' => [
                'required',
                'numeric',
                'min:100'
            ]
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
          'value.required' => 'Поле-Сумма обязательная к заполнению.',
          'value.min' => 'Минимальная пополнение от 1000$.',
        ];
    }
}
