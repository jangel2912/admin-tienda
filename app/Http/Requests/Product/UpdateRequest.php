<?php

namespace App\Http\Requests\Product;

use App\Rules\Product\TheCodeMustNotExist;
use App\Rules\TheCategoryMustExist;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'code' => ['nullable', 'string', new TheCodeMustNotExist($this->product)],
            'name' => 'required|string|max:100',
            'category' => ['required', 'numeric', 'min:1', new TheCategoryMustExist],
            'description' => 'required|string|max:150',
            'featured' => 'nullable|string',
            'sell_without_stock' => 'nullable|string',
            'show_stock' => 'nullable|string',
            'long_description' => 'nullable|string',
            'quantity' => 'required_without:reference|numeric|min:0',
            'buy_price' => 'required_without:reference|numeric|min:0',
            'sale_price' => 'required_without:reference|numeric|min:0',
            'imagen' => 'nullable|mimes:jpeg,jpg,png',
            'imagen1' => 'nullable|mimes:jpeg,jpg,png',
            'imagen2' => 'nullable|mimes:jpeg,jpg,png',
            'imagen3' => 'nullable|mimes:jpeg,jpg,png',
            'imagen4' => 'nullable|mimes:jpeg,jpg,png',
            'imagen5' => 'nullable|mimes:jpeg,jpg,png',
            'attributes.*' => 'nullable|string|max:50',
            'details.*' => 'nullable|string',
            'products.*' => 'required|string',
            'codes.*' => 'nullable|string',
            'quantities.*' => 'required|numeric|min:0',
            'buy_prices.*' => 'required|numeric|min:0',
            'sale_prices.*' => 'required|numeric|min:0',
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
            'quantity.required_without' => 'La cantidad del producto es requerida.',
            'buy_price.required_without' => 'El precio de compra del producto es requerido.',
            'sale_price.required_without' => 'El precio de venta del producto es requerido.',
        ];
    }
}
