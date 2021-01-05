<?php

namespace App\Http\Requests\Category;

use App\Rules\TheCategoryMustExist;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'code' => 'nullable|string',
            'name' => 'required|string',
            'father' => ['nullable', 'numeric', new TheCategoryMustExist],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre de la categoría es requerido'
        ];
    }
}
