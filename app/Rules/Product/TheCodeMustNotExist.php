<?php

namespace App\Rules\Product;

use App\Models\Shop\Product;
use Illuminate\Contracts\Validation\Rule;

class TheCodeMustNotExist implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($except = null)
    {
        $this->except = $except;
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
        return is_null(Product::where([
            ['codigo', $value],
            ['id', '<>', $this->except]
        ])->first());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El código ya existe para otro producto.';
    }
}
