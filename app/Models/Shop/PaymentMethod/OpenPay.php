<?php

namespace App\Models\Shop\PaymentMethod;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OpenPay
 * @package App\Models\Shop\PaymentMethod
 * @property-read integer $id
 * @property string $client_id
 * @property string $public_key
 * @property string $private_key
 * @property bool $active
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class OpenPay extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'openpay_credentials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'public_key', 'private_key', 'active'
    ];
}
