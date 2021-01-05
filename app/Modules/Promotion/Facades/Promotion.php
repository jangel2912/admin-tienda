<?php


namespace App\Modules\Promotion\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class Promotion
 * @package App\Modules\Promotion\Facades
 * @method static \App\Models\Shop\Promotion\Promotion create(array $request)
 */
class Promotion extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'module.promotion';
    }
}
