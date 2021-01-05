<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TheCurrencyMustExistInTheArray implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $currencies = collect(include resource_path('currencies/all.php'));
        return !is_null($currencies->where('AlphabeticCode', $value)->first());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La moneda que intenta usar no es válida.';
    }
}
