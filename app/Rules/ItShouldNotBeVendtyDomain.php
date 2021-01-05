<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ItShouldNotBeVendtyDomain implements Rule
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
        $value = parse_shop_domain($value);
        $store = parse_shop_domain(env('APP_STORE'));

        return $value != $store;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El dominio no puede ser ' . env('APP_STORE');
    }
}
