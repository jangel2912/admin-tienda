<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TheCountryMustExistInTheArray implements Rule
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
        $countries = collect(include resource_path('countries/all.php'));
        $search = $countries->search($value, true);

        return $search !== false && $search >= 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El país no es válido.';
    }
}
