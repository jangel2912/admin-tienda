<?php

namespace App\Models\Shop\Coupon;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
/**
 * Class MercadoPago
 * @package App\Models\Shop\PaymentMethod
 * @property-read integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property enum $tipo
 * @property date $fecha_caducidad
 * @property double $importe
 * @property double $gasto_minimo
 * @property double $gasto_maximo
 * @property boolean $uso_individual
 * @property string $correos_electronicos
 * @property string $correos_electronicos
 * @property integer $limites_uso
 * @property integer $limites_uso_usuario
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class Coupon extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'cupon';

    /**
     * @var array
     */
    protected $fillable = [
        'nombre', 
        'descripcion', 
        'tipo', 
        'importe', 
        'fecha_caducidad', 
        'gasto_minimo', 
        'gasto_maximo', 
        'uso_individual', 
        'correos_electronicos',
        'limites_uso',
        'limites_uso_usuario'
    ];

    /**
     * @return Carbon
     */
    public function getEndInAttribute(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d', $this->fecha_caducidad);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(CategoryCoupon::class, 'cupon_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(CouponProduct::class, 'cupon_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients()
    {
        return $this->hasMany(CouponClient::class, 'cupon_id');
    }

    public function getCouponTypeAttribute() {
        switch($this->tipo){
            case "descuento_en_porsentaje":
                return "Descuento en porcentaje";
            case "descuento_fijo_en_carrito":
                return "Descuento fijo en carrito";
            default:
                return "Descuento fijo de producto";
        }
    }


}
