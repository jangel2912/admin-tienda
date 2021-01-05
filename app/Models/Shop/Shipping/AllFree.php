<?php

namespace App\Models\Shop\Shipping;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AllFree
 * @package App\Models\Shop\Shipping
 * @property bool $activo
 * @mixin \Eloquent
 */
class AllFree extends Model
{
    /**
     * Nombre de la conexión
     *
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * Nombre de la tabla
     *
     * @var string
     */
    protected $table = 'envios_todos_gratis';
}
