<?php

namespace App\Http\Requests;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string|between:3,50',
            'last_name' => 'required|string|between:3,50',
            'email' => 'required|email|unique:users,email|between:10,100',
            'phone' => 'required|string|between:7,15',
            'shopname' => 'required|string|between:3,50',
        ];
    }
}
