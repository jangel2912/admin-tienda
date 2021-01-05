<?php

namespace App\Models\Shop\Movement;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Detail
 * @package App\Models\Shop\Movement
 * @property-read integer $id_detalle
 * @property integer $id_inventario
 * @property string $codigo_barra
 * @property integer $cantidad
 * @property float $precio_compra
 * @property float $existencias
 * @property string $nombre
 * @property float $total_inventario
 * @property integer $producto_id
 * @mixin \Eloquent
 */
class Detail extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'movimiento_detalle';

    /**
     * @var string
     */
    protected $primaryKey = 'id_detalle';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_inventario', 'codigo_barra', 'cantidad', 'precio_compra', 'existencias', 'nombre', 'total_inventario', 'producto_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    function __construct()
    {
        parent::__construct();
    }
}
