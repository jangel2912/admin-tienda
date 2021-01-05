<?php

namespace App\Http\Requests;

use App\Rules\ItShouldNotBeVendtyDomain;
use App\Rules\TheCountryMustExistInTheArray;
use App\Rules\TheCurrencyMustExistInTheArray;
use App\Rules\TheTimezoneMustExistInTheArray;
use App\Rules\TheWarehouseMustExist;
use App\Rules\UniqueDomain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingBasicUpdateRequest extends FormRequest
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
            'shopname' => ['required', 'string', 'between:3,50'],
            'correo' => ['required', 'email:rfc,strict,dns,spoof,filter', 'between:10,200'],
            'dominio_local' => ['required', 'alpha_num', Rule::unique('tienda', 'dominio_local')->ignore(auth_user()->db_config_id, 'id_db')],
            'warehouse' => ['required', 'numeric', 'min:1', new TheWarehouseMustExist],
            //'dominio' => ['nullable', 'active_url', new ItShouldNotBeVendtyDomain, new UniqueDomain],
            'country' => ['required', 'alpha', new TheCountryMustExistInTheArray],
            'currency' => ['required', 'alpha', new TheCurrencyMustExistInTheArray],
            'symbol' => 'required|string|max:4',
            'monto' => 'required|numeric|digits_between:1,15',
            'timezone' => ['required', 'string', new TheTimezoneMustExistInTheArray]
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'currency.required' => 'Debe definir en nombre de la moneda.',
            'symbol.required' => 'Por favor, indique el simbolo de la moneda que desea usar'
        ];
    }
}
