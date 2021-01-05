<?php

namespace App\Models\Shop\PaymentMethod;

use Illuminate\Database\Eloquent\Model;
/**
 * Class MercadoPago
 * @package App\Models\Shop\PaymentMethod
 * @property-read integer $id
 * @property string $merchant_public_id
 * @property string $merchant_private_id
 * @property bool $active
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class Paymentez extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'paymentez_credentials';

    /**
     * @var array
     */
    protected $fillable = [
        'paymentez_app_code_client', 
        'paymentez_app_key_client', 
        'paymentez_app_code_server', 
        'paymentez_app_key_server', 
        'paymentez_environment', 
        'active'
    ];
}
