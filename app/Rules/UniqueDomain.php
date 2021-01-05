<?php

namespace App\Rules;

use App\Models\Vendty\Shop;
use Illuminate\Contracts\Validation\Rule;

class UniqueDomain implements Rule
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
        $domain = parse_shop_domain($value);
        $shop = Shop::where([
            ['dominio', $domain],
            ['id_db', '<>', auth_user()->db_config_id],
        ])->first();

        return is_null($shop);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El valor del campo dominio ya está en uso.';
    }
}
