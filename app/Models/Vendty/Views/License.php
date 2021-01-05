<?php

namespace App\Models\Vendty\Views;

use App\Models\Customer\Warehouse\Warehouse;
use App\Models\Vendty\DBConfig;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class License
 * @package App\Models\Vendty\Views
 * @property-read string|null $fecha_inicio_licencia
 * @property-read bool $desactivada
 * @property-read string|null $fecha_desactivada
 * @property-read string|null $fecha_activacion
 * @property-read int $idempresas_clientes
 * @property-read string|null $nombre_empresa
 * @property-read int|null $id_db_config
 * @property-read int $estado_licencia
 * @property-read string|null $descripcion
 * @property-read \Carbon\Carbon|null $fecha_creacion
 * @property-read string|null $fecha_vencimiento
 * @property-read \Carbon\Carbon|null $fecha_modificacion
 * @property-read string|null $nombre_plan
 * @property-read double|null $valor_plan
 * @property-read double|null $valor_plan_dolares
 * @property-read int|null $id_almacen
 * @property-read int $id_plan
 * @property-read int $id_licencia
 * @property-read \App\Models\Vendty\DBConfig $dbConfig
 * @property-read \App\Models\Customer\Restaurant\Warehouse\ $warehouse
 * @mixin \Eloquent
 */
class License extends Model
{
    /**
     * @var string
     */
    protected $table = 'v_crm_licencias';

    /**
     * @var array
     */
    protected $hidden = [
        'id_db_config'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'fecha_creacion', 'fecha_modificacion'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'fecha_desactivada' => 'datetime:Y-m-d',
        'fecha_activacion' => 'datetime:Y-m-d',
        'fecha_vencimiento' => 'datetime:Y-m-d',
        'desactivada' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dbConfig()
    {
        return $this->belongsTo(DBConfig::class, 'id_db_config');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'id_almacen');
    }

    /**
    * Scope a query to only include active users.
    *
    * @param  \Illuminate\Database\Eloquent\Builder  $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeEnabled($query)
    {
        return $query->whereNotIn('id_plan', [15, 16, 17])
            ->where('estado_licencia', 15)
            ->orWhere('fecha_vencimiento', Carbon::now()->format('Y-m-d'))
            ->where('desactivada', '!=', 1);
    }
}
