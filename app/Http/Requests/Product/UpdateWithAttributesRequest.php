<?php

namespace App\Http\Requests\Product;

use App\Rules\Product\TheCodeMustNotExist;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWithAttributesRequest extends FormRequest
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
            'quantity.required' => 'La cantidad del producto es requerida.',
            'buy_price.required' => 'El precio de compra del producto es requerido.',
            'sale_price.required' => 'El precio de venta del producto es requerido.',
        ];
    }
}
