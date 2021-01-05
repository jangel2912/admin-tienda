<?php

namespace App\Models\Shop\Movement;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventory
 * @package App\Models\Shop\Movement
 * @property-read integer $id
 * @property \Carbon\Carbon $fecha
 * @property integer $almacen_id
 * @property string $tipo_movimiento
 * @property integer $user_id
 * @property float $total_inventario
 * @mixin \Eloquent
 */
class Inventory extends Model
{    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'movimiento_inventario';

    /**
     * @var array
     */
    protected $attributes = [
        'fecha' => null,
        'user_id' => null,
        'tipo_movimiento' => 'entrada_producto',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha', 'almacen_id', 'tipo_movimiento', 'user_id', 'total_inventario'
    ];

    protected $dates = [
        'fecha'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    function __construct()
    {
        parent::__construct();
        $this->attributes['fecha'] = Carbon::now()->format('Y-m-d H:i:s');
        $this->attributes['user_id'] = auth()->id();
    }
}
