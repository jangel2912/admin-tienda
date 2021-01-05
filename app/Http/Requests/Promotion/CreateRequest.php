<?php

namespace App\Http\Requests\Promotion;

use App\Rules\TheProductMustBeActiveForStore;
use App\Rules\TheProductMustExist;
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
            'name' => 'required|string',
            'days' => 'required|array',
            'initial_date' => 'required|date_format:Y-m-d',
            'initial_time' => 'required|date_format:H:i',
            'final_date' => 'required|date_format:Y-m-d',
            'final_time' => 'required|date_format:H:i',
            'products' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre de la promocio es requerido',

            'days.required' => 'Debe seleccionar al menos un dia de la semana',

            'initial_date.required' => 'Debe indicar la fecha de inicio de la promoción.',
            'initial_date.date_format' => 'El formato de la fecha no es valido.',

            'initial_time.required' => 'Debe indicar la hora de inicio de la promoción.',
            'initial_time.date_format' => 'El formato de la hora no es valido.',

            'final_date.required' => 'Debe indicar la fecha final de la promoción.',
            'final_date.date_format' => 'El formato de la fecha no es valido.',

            'final_time.required' => 'Debe indicar la hora final de la promoción.',
            'final_time.date_format' => 'El formato de la hora no es valido.',
        ];
    }
}
