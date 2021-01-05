<?php

namespace App\Http\Requests;

use App\Rules\ItShouldNotBeVendtyDomain;
use App\Rules\TheCountryMustExistInTheArray;
use App\Rules\TheCurrencyMustExistInTheArray;
use App\Rules\TheWarehouseMustExist;
use App\Rules\UniqueDomain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingDomainsUpdateRequest extends FormRequest
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
            //'dominio_local' => ['required', 'alpha_num', Rule::unique('tienda', 'dominio_local')->ignore(auth_user()->db_config_id, 'id_db')],
            'dominio' => ['nullable', 'active_url', new ItShouldNotBeVendtyDomain, new UniqueDomain],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
           
        ];
    }
}
