<?php

namespace App\Models\Shop\PaymentMethod;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cash
 * @package App\Models\Shop\PaymentMethod
 * @property-read int $id
 * @property bool $active
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class Cash extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'cash_credentials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active'
    ];
}
