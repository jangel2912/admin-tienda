<?php

namespace App\Http\Requests\Wizard;

// use App\Rules\Domain;
use App\Rules\ItShouldNotBeVendtyDomain;
use App\Rules\TheCountryMustExistInTheArray;
use App\Rules\TheCurrencyMustExistInTheArray;
use App\Rules\TheWarehouseMustExist;
use App\Rules\UniqueDomain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetFirstStepRequest extends FormRequest
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
            'dominio_local' => ['required', 'alpha_num', Rule::unique('tienda', 'dominio_local')->ignore(auth_user()->db_config_id, 'id_db')],
            'warehouse' => ['required', 'numeric', 'min:1', new TheWarehouseMustExist],
            // 'domain' => ['nullable', 'url', new ItShouldNotBeVendtyDomain, new Domain],
            'dominio' => ['nullable', 'active_url', new ItShouldNotBeVendtyDomain, new UniqueDomain],
            'country' => ['required', 'alpha', new TheCountryMustExistInTheArray],
            'currency' => ['required', 'alpha', new TheCurrencyMustExistInTheArray],
        ];
    }
}
