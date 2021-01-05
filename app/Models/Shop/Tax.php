<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    /**
     * Nombre de la conexion
     *
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * Nombre de la tabla
     *
     * @var string
     */
    protected $table = 'impuesto';

    /**
     * Nombre de la llave primaria
     *
     * @var string
     */
    protected $primaryKey = 'id_impuesto';

    /**
     * Deshabilitamos los campos created_at y updated_at
     * @var bool
     */
    public $timestamps = false;
}
