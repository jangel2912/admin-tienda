<?php
/**
 * Created by adminshop.
 * User: Rafael Moreno
 * Date: 28/02/2019
 * Time: 4:46 PM
 */

namespace App\Tools\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class Domain
 * @package App\Tools\Facades
 * @method static validate(string $domain)
 * @method static process(string $domain)
 */
class Domain extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tool.domain';
    }
}
