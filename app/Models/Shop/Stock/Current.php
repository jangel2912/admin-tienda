<?php

namespace App\Models\Shop\Stock;

use App\Models\Shop\Product;
use App\Models\Shop\Warehouse;
use App\Setters\Stock\Current as CurrentSetAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Current
 * @package App\Models\Shop\Stock
 * @property-read integer $id
 * @property integer $almacen_id
 * @property integer $producto_id
 * @property integer $unidades
 * @property-read \App\Models\Shop\Warehouse $warehouse
 * @property-read \App\Models\Shop\Product $product
 * @mixin \Eloquent
 */
class Current extends Model
{
    use CurrentSetAttributes;

    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'stock_actual';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'almacen_id', 'producto_id', 'unidades'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'almacen_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }
}
