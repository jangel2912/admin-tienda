<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingSlidersUpdateRequest extends FormRequest
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
            'slider1' => 'nullable|mimes:jpeg,jpg,png',
            'slider2' => 'nullable|mimes:jpeg,jpg,png',
            'slider3' => 'nullable|mimes:jpeg,jpg,png',
            'slider4' => 'nullable|mimes:jpeg,jpg,png',
            'slider5' => 'nullable|mimes:jpeg,jpg,png',
            'slider6' => 'nullable|mimes:jpeg,jpg,png',
        ];
    }
}
