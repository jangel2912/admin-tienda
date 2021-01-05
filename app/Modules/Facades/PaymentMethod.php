<?php
/**
 * Created by adminshop.
 * User: Rafael Moreno
 * Date: 22/11/2018
 * Time: 12:10 PM
 */

namespace App\Modules\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class PaymentMethod
 * @package App\Modules\Facades
 * @method static disablePayment()
 */
class PaymentMethod extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'payment.method';
    }
}
