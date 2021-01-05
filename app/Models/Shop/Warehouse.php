<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Warehouse
 * @package App\Models\Shop
 * @property-read integer $id
 * @property-read string|null $resolucion_factura
 * @property-read string|null $nit
 * @property-read integer|null $numero_fin
 * @property-read string|null $fecha_vencimiento
 * @property-read integer|null $numero_alerta
 * @property-read integer|null $fecha_alerta
 * @property-read string|null $nombre
 * @property-read string|null $direccion
 * @property-read float|null $meta_diaria
 * @property-read string|null $prefijo
 * @property-read integer|null $consecutivo
 * @property-read boolean $activo
 * @property-read string $telefono
 * @property-read string|null $tipo_almacen
 * @property-read string $ciudad
 * @property-read string|null $pais
 * @property-read string|null $razon_social
 * @property-read boolean $bodega
 * @property-read integer $consecutivo_orden_restaurante
 * @property-read integer $reiniciar_consecutivo_orden_restaurante
 * @mixin \Eloquent
 */
class Warehouse extends Model
{
    /**
     * @var string
     */
	protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'almacen';
}
