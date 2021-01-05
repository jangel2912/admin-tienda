<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permit
 * @package App\Models\Shop
 * @property-read \App\Models\Shop\User $user
 * @mixin \Eloquent
 */
class Permit extends Model
{
    /**
     * @var string
     */
	protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'permiso_rol';
}
