<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Product\OnlineVentaProductAdition;
use App\Models\Shop\Product\OnlineVentaProductModification;

/**
 * Class OnlineSaleProd
 * @package App\Models\Shop
 * @property-read \App\Models\Shop\OnlineVenta $onlineVenta
 * @mixin \Eloquent
 */
class OnlineSaleProd extends Model
{
    /**
     * @var string
     */
	protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'online_venta_prod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_venta', 'id_producto', 'descripcion', 'precio', 'cantidad', 'total'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function onlineVenta()
    {
    	return $this->belongsTo(OnlineSale::class, 'id_venta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function onlineVentaAditions()
    {
        return $this->hasMany(OnlineVentaProductAdition::class, 'online_venta_prod_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function onlineVentaModifications()
    {
        return $this->hasMany(OnlineVentaProductModification::class, 'online_venta_prod_id');
    }
}
