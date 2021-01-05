<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 * @package App\Models\Shop
 * @property-read int $id
 * @property string $pais
 * @property string $provincia
 * @property string $nombre_comercial
 * @property string $razon_social
 * @property string $tipo_identificacion
 * @property string $nif_cif
 * @property string $contacto
 * @property string $pagina_web
 * @property string $email
 * @property string $poblacion
 * @property string $direccion
 * @property string $cp
 * @property string $telefono
 * @property string $movil
 * @property string $fax
 * @property string $tipo_empresa
 * @property string $entidad_bancaria
 * @property string $numero_cuenta
 * @property int $observaciones
 * @property int $grupo_clientes_id
 * @property bool $onlineTienda
 * @property string $password
 * @property string $fecha_nacimiento
 * @property string $genero
 * @mixin \Eloquent
 */
class Customer extends Model
{
    /**
     * @var string
     */
	protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'clientes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pais', 'provincia', 'nombre_comercial', 'razon_social', 'tipo_identificacion', 'nif_cif', 'contacto', 'pagina_web', 'email', 'poblacion', 'direccion', 'cp', 'telefono', 'movil', 'fax', 'tipo_empresa', 'entidad_bancaria', 'numero_cuenta', 'observaciones', 'grupo_clientes_id', 'onlineTienda', 'password', 'fecha_nacimiento', 'genero'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
