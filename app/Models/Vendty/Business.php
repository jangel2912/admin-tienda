<?php

namespace App\Models\Vendty;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Business
 * @package App\Models\Vendty
 * @property-read int $idempresas_clientes
 * @property string $nombre_empresa
 * @property string $direccion_empresa
 * @property string $telefono_contacto
 * @property int $idusuario_creacion
 * @property int $id_db_config
 * @property int $id_distribuidores_licencia
 * @property int $id_user_distribuidor
 * @property string $identificacion_empresa
 * @property string $tipo_identificacion
 * @property string $razon_social_empresa
 * @property string $ciudad_empresa
 * @property string $departamento_empresa
 * @property string $pais
 * @property string $valor_renovacion
 * @property string $tipo_negocio
 * @mixin \Eloquent
 */
class Business extends Model
{
    /**
     * @var string
     */
    protected $table = 'crm_empresas_clientes';

    /**
     * @var string
     */
    protected $primaryKey = 'idempresas_clientes';

    /**
     * @var array
     */
    protected $fillable = [
        'nombre_empresa', 'direccion_empresa', 'telefono_contacto', 'idusuario_creacion', 'id_db_config', 'id_distribuidores_licencia', 'id_user_distribuidor', 'identificacion_empresa', 'tipo_identificacion', 'razon_social_empresa', 'ciudad_empresa', 'departamento_empresa', 'pais', 'valor_renovacion', 'tipo_negocio'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
