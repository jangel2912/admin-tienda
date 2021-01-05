<?php

namespace App\Repositories\Facades\Vendty;

use Illuminate\Support\Facades\Facade;

/**
 * Class Shop
 * @package App\Repositories\Facades\Vendty
 * @method static \App\Models\Vendty\Shop get()
 * @method static bool update(array $data)
 */
class Shop extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'repository.vendty.shop';
    }
}
