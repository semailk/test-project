<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WithdrawRequest extends FormRequest
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
            'withdraw' => [
                'required',
                'numeric',
                'min:1'
            ]
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'withdraw.required' => 'Поля вывода обзательна к заполнению.',
            'withdraw.numeric' => 'Поля вывода должно быть числом.',
            'withdraw.min' => 'К выводу минимум 1-акция.'
        ];
    }
}
