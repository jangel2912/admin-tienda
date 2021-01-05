<?php

namespace App\Models\Shop;

use App\Getters\Product as ProductGetAttributes;
use App\Models\Shop\Product\Reference;
use App\Models\Shop\Product\DetailProduct;
use App\Models\Shop\Tax;
use App\Models\Shop\Stock\Current;
use App\Presenters\Product as ProductPresenter;
use App\QueryScopes\Shop\Product as ProductScope;
use App\Setters\Product as ProductSetAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App\Models\Shop
 * @property-read integer $id
 * @property string $categoria_id
 * @property string $codigo
 * @property string $nombre
 * @property float $precio_compra
 * @property float $precio_venta
 * @property bool $vendernegativo
 * @property bool $mostrar_stock
 * @property string $descripcion
 * @property string $descripcion_larga
 * @property bool $activo
 * @property bool $destacado_tienda
 * @property-read \App\Models\Shop\Stock\Current $currentStock
 * @property \App\Models\Shop\Category|int $category
 * @mixin \Eloquent
 */
class Product extends Model
{
    use ProductSetAttributes, ProductGetAttributes;

    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'producto';

    /**
     * @var array
     */
    protected $attributes = [
        'stock_maximo' => 0,
        'fecha_vencimiento' => '',
        'ubicacion' => '',
        'ganancia' => 0,
        'tienda' => true
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'categoria_id', 'codigo', 'nombre', 'precio_compra', 'precio_venta', 'vendernegativo', 'mostrar_stock', 'descripcion', 'descripcion_larga', 'activo', 'destacado_tienda'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ProductScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currentStock()
    {
        return $this->hasOne(Current::class, 'producto_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reference()
    {
        return $this->belongsTo(Reference::class, 'referencia_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detailProduct()
    {
        return $this->hasOne(DetailProduct::class, 'producto_id');
    }

    /**
     * @return ProductPresenter
     */
    public function present()
    {
        return new ProductPresenter($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tax()
    {
        return $this->hasOne(Tax::class, 'id_impuesto', 'impuesto');
    }
}
