<?php
/**
 * Created by vendty.
 * User: Rafael Moreno
 * Date: 25/02/2019
 * Time: 3:47 PM
 */

namespace App\Tools\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class Password
 * @package App\Tools\Facades
 * @method static bool|string hash(string $password, string $salt = null, $useSha1Override = false)
 * @method static bool validate(User $user, string $password, $useSha1Override = false)
 */
class Password extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tools.password';
    }
}