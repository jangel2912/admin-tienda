<?php

namespace App\Http\Requests\Product;

use App\Rules\Product\TheCodeMustNotExist;
use App\Rules\TheCategoryMustExist;
use App\Rules\TheTaxMustExist;
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
            'code' => ['nullable', 'string', new TheCodeMustNotExist],
            'name' => 'required|string|max:100',
            'category' => ['required', 'numeric', 'min:1', new TheCategoryMustExist],
            'description' => 'required|string|max:150',
            'featured' => 'nullable|string',
            'sell_without_stock' => 'nullable|string',
            'show_stock' => 'nullable|string',
            'long_description' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'tax' => ['nullable', 'numeric', 'min:1', new TheTaxMustExist],
            'buy_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'imagen' => 'nullable|mimes:jpeg,jpg,png',
            'imagen1' => 'nullable|mimes:jpeg,jpg,png',
            'imagen2' => 'nullable|mimes:jpeg,jpg,png',
            'imagen3' => 'nullable|mimes:jpeg,jpg,png',
            'imagen4' => 'nullable|mimes:jpeg,jpg,png',
            'imagen5' => 'nullable|mimes:jpeg,jpg,png',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre del producto es requerido.',
            'category.required' => 'Debe seleccionar una categoría para el producto.',
            'category.numeric' => 'Debe seleccionar una categoría valida.',
            'category.min' => 'Debe seleccionar una categoría valida.',
            'description.required' => 'Debe indicar alguna descripción para el producto.',
        ];
    }
}
