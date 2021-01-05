<?php

namespace App\Rules;

use App\Tools\Facades\Domain as DomainFacade;
use Illuminate\Contracts\Validation\Rule;

class Domain implements Rule
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
        return DomainFacade::validate($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El DNS de su dominio no se ha configurado en el panel de su proveedor de dominio.';
    }
}
