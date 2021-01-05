<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserStore
 * @package App\Models\Shop
 * @mixin \Eloquent
 */
class UserStore extends Model
{
    /**
     * @var string
     */
	protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'usuario_almacen';
}
