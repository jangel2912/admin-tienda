<?php

namespace App\Models\Shop;

use App\Getters\OnlineSale as OnlineSaleGetAttributes;
use App\Presenters\OnlineSale as OnlineSalePresenter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Coupon\CouponClient;

/**
 * Class OnlineSale
 * @package App\Models\Shop
 * @property-read \App\Models\OnlineSaleProd $onlineVentaProd
 * @mixin \Eloquent
 */
class OnlineSale extends Model
{
    use OnlineSaleGetAttributes;

    /**
     * @var string
     */
	protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'online_venta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'nombre2', 'apellidos', 'dni', 'telefono', 'movil', 'fax', 'email', 'cpostal', 'direccion', 'poblacion', 'notas', 'fecha', 'sub_total', 'tasa_impuesto', 'estado', 'id_transac', 'metodo_pago', 'venta_id'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'fecha'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function onlineVentaProd()
    {
        return $this->hasMany(OnlineSaleProd::class, 'id_venta');
    }

    /**
     * @return OnlineSalePresenter
     */
    public function present()
    {
        return new OnlineSalePresenter($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients()
    {
        return $this->hasMany(CouponClient::class, 'online_venta_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedule()
    {
        return $this->hasOne(OnlineVentaSchedule::class, 'online_venta_id');
    }
}
