<?php

namespace App\Models\Shop\Product;

use App\Models\Shop\OnlineSaleProd;
use App\Models\Shop\Product\Aditional;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App\Models\Shop
 * @property-read integer $id
 * @property-read integer $categoria_id
 * @property-read string|null $codigo
 * 
 * @mixin \Eloquent
 */
class OnlineVentaProductAdition extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'online_venta_prod_adition';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function onlineVentaProduct()
    {
        return $this->belongsTo(OnlineSaleProd::class, 'online_venta_prod_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adition()
    {
        return $this->belongsTo(Aditional::class, 'producto_adicional_id');
    }


}
