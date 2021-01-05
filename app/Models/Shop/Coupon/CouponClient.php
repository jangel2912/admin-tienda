<?php

namespace App\Models\Shop\Coupon;

use App\Getters\OnlineSale;
use Illuminate\Database\Eloquent\Model;
/**
 * Class MercadoPago
 * @package App\Models\Shop\PaymentMethod
 * @property-read integer $id
 * @property integer $categoria_id
 * @property integer $cupon_id
 * @property enum $tipo
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class CouponClient extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'cupon_cliente';

    /**
     * @var array
     */
    protected $fillable = [
        'id_cliente', 
        'cupon_id', 
        'online_venta_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'cupon_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Customer::class, 'id_cliente', 'id_cliente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function onlinesale()
    {
        return $this->belongsTo(OnlineSale::class, 'online_venta_id', 'id');
    }

    
}
