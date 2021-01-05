<?php

namespace App\Http\Requests;

use App\Rules\ItShouldNotBeVendtyDomain;
use App\Rules\TheCountryMustExistInTheArray;
use App\Rules\TheCurrencyMustExistInTheArray;
use App\Rules\TheWarehouseMustExist;
use App\Rules\UniqueDomain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingLogosUpdateRequest extends FormRequest
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
            'favicon' => 'nullable|mimes:jpeg,jpg,png,ico',
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
