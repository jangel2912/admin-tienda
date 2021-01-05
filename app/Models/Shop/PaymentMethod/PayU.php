<?php

namespace App\Models\Shop\PaymentMethod;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PayU
 * @package App\Models\Shop\PaymentMethod
 * @property-read integer $id
 * @property string $merchant_id
 * @property string $account_id
 * @property string $api_key
 * @property bool $active
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class PayU extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'payu_credentials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_id', 'account_id', 'api_key', 'active'
    ];
}
