<?php

namespace App\Models\Shop\Coupon;

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
class CategoryCoupon extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'cupon_categoria';

    /**
     * @var array
     */
    protected $fillable = [
        'categoria_id', 
        'cupon_id', 
        'tipo'
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
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_id', 'id');
    }
    
}
