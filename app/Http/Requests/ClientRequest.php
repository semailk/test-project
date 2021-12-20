<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'surname' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'phone' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
        ];
    }

    /**
     * Перевод ошибок на русский язык
     *
     * @return string[]
     */
    public function messages()
    {
        return [
            'name.required' => 'Name поле объязательно к заполнению!',
            'surname.required' => 'Surname поле объязательно к заполнению!',
            'phone.required' => 'Phone поле объязательно к заполнению!',
        ];
    }
}
