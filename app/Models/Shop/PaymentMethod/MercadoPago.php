<?php

namespace App\Models\Shop\PaymentMethod;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MercadoPago
 * @package App\Models\Shop\PaymentMethod
 * @property-read integer $id
 * @property string $public_key
 * @property string $access_token
 * @property bool $active
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class MercadoPago extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'mercadopago_credentials';

    /**
     * @var array
     */
    protected $fillable = [
        'public_key', 'access_token', 'active'
    ];
}
