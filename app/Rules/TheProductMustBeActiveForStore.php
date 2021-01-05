<?php

namespace App\Rules;

use App\Models\Shop\Product;
use Illuminate\Contracts\Validation\Rule;

class TheProductMustBeActiveForStore implements Rule
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
        !is_null(Product::where(['id' => $value, 'tienda' => true])->first());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El producto no esta habilitado para vender en la tienda online.';
    }
}
