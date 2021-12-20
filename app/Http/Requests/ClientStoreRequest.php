<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientStoreRequest extends FormRequest
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
                'min:3',
                'max:200',
                'string'
            ],
            'surname' => [
                'required',
                'min:3',
                'max:200',
                'string'
            ],
            'phone' => [
                'required',
                'min:3',
                'max:200',
                'string'
            ],
            'email' => [
                'required',
                'email',
                'min:5',
                'max:200',
                Rule::unique('clients','email')
            ],
            'manager_id' => [
                'required',
            ],
            'source_id' => [
                'integer',
                Rule::exists('sources','id')
            ],
            'fee' => [
                'array'
            ]
        ];
    }
}
