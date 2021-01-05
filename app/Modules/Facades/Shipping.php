<?php
/**
 * Created by adminshop.
 * User: Rafael Moreno
 * Date: 16/11/2018
 * Time: 3:18 PM
 */

namespace App\Modules\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Shipping
 * @package App\Modules\Facades
 */
class Shipping extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shipping';
    }
}
