<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Visit
 * @package App\Models\Shop
 * @mixin \Eloquent
 */
class Visit extends Model
{
    /**
	 * [$connection description]
	 * @var string
	 */
	protected $connection = 'mysql_shop';
}
