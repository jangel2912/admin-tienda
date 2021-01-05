<?php

namespace App\Http\Requests\Coupons;

use App\Rules\TheProductMustBeActiveForStore;
use App\Rules\TheProductMustExist;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            //'nombre' => "unique:mysql_shop.cupon,nombre,{$this->id}|required|string|max:100",
            'nombre' => 'required|string|max:100',
            /*'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('mysql_shop.cupon')->ignore($this->id)
            ],*/
            'descripcion' => 'max:250',
            'tipo' => 'required',
            'importe' => "required|numeric|porciento:{$this->tipo}",
            'gasto_minimo' => 'numeric',
            'gasto_maximo' => 'numeric',
            'fecha_caducidad' => 'date_format:Y-m-d',
            'productos' => 'array',
            'productos_excluidos' => 'array',
            'categorias' => 'array',
            'categorias_excluidas' => 'array',
            'limites_uso' => 'integer',
            'limites_uso_usuario' => 'integer'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre del cupón es requerido',
            'tipo.required' => 'El tipo del cupón es requerido',
            'importe.required' => 'El importe es requerido',
            'importe.numeric' => 'El importe debe ser numérico',
            'gasto_maximo.numeric' => 'El gasto máximo debe ser numérico',
            'gasto_minimo.numeric' => 'El gasto mínimo debe ser numérico',
            'importe.porciento' => 'El porciento debe ser menor o igual a 100'
            /*'days.required' => 'Debe seleccionar al menos un dia de la semana',

            'initial_date.required' => 'Debe indicar la fecha de inicio de la promoción.',
            'initial_date.date_format' => 'El formato de la fecha no es valido.',

            'initial_time.required' => 'Debe indicar la hora de inicio de la promoción.',
            'initial_time.date_format' => 'El formato de la hora no es valido.',

            'final_date.required' => 'Debe indicar la fecha final de la promoción.',
            'final_date.date_format' => 'El formato de la fecha no es valido.',

            'final_time.required' => 'Debe indicar la hora final de la promoción.',
            'final_time.date_format' => 'El formato de la hora no es valido.',*/
        ];
    }
}
