<?php

namespace App\Models\Shop\Stock;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Daily
 * @package App\Models\Shop\Stock
 * @property-read integer $id
 * @property integer $producto_id
 * @property integer $almacen_id
 * @property string $fecha
 * @property string $razon
 * @property string $cod_documento
 * @property float $unidad
 * @property float $precio
 * @property integer $usuario
 * @mixin \Eloquent
 */
class Daily extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'stock_diario';

    /**
     * @var array
     */
    protected $attributes = [
        'fecha' => null,
        'usuario' => null,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'producto_id', 'almacen_id', 'fecha', 'razon', 'cod_documento', 'unidad', 'precio', 'usuario'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    function __construct()
    {
        parent::__construct();
        $this->attributes['fecha'] = Carbon::now()->format('Y-m-d');
        $this->attributes['usuario'] = auth()->id();
    }
}
