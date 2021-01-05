<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SaleGoal
 * @package App\Models\Shop
 * @mixin \Eloquent
 */
class SaleGoal extends Model
{
    /**
     * @var string
     */
	protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'meta_ventas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'monto'
    ];

}
