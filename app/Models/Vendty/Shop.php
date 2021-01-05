<?php

namespace App\Models\Vendty;

use App\Models\Shop\Warehouse;
use App\Tools\Facades\Domain;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Shop
 * @package App\Models\Vendty
 * @property-read int $id
 * @property int $id_user
 * @property int $id_db
 * @property int $id_almacen
 * @property string $shopname
 * @property string $layout
 * @property string $description
 * @property bool $activo
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $logo
 * @property string $google_map
 * @property string $google_analytics
 * @property string $slider1
 * @property string $slider2
 * @property string $slider3
 * @property string $slider4
 * @property string $slider5
 * @property string $slider6
 * @property string $merchantId
 * @property string $accountId
 * @property string $ApiKey
 * @property string $cuentabancaria
 * @property string $nombrebanco
 * @property string $tipocuenta
 * @property string $nombretitular
 * @property string $correo
 * @property string $imagenQuienesSomos1
 * @property string $imagenQuienesSomos2
 * @property string $descripcionQuienesSomos
 * @property string $tituloQuienesSomos
 * @property string $apikeyEPayco
 * @property string $publickeyEPayco
 * @property string $idClienteEPayco
 * @property string $terminos_condiciones_titulo
 * @property string $terminos_condiciones
 * @property string $propiedad_intelectual_titulo
 * @property string $propiedad_intelectual
 * @property string $cambios_devoluciones_titulo
 * @property string $cambios_devoluciones
 * @property string $tratamiento_datos_titulo
 * @property string $tratamiento_datos
 * @property string $fondo
 * @property string $logo_inferior
 * @property string $favicon
 * @property bool $stock_almacen
 * @property bool $cobro_envios
 * @property bool $menu_estatico
 * @property string $color_fondo_menu
 * @property string $color_letra_menu
 * @property string $color_fondo_pie_pagina
 * @property string $color_letra_pie_pagina
 * @property string $dominio
 * @property int $productos_destacados
 * @property int $productos_recientes
 * @property string $link_slider1
 * @property string $link_slider2
 * @property string $link_slider3
 * @property string $link_slider4
 * @property string $link_slider5
 * @property string $link_slider6
 * @property string $imagen_parallax
 * @property string $texto_parallax
 * @property string $texto_boton_parallax
 * @property string $link_parallax
 * @property bool $contraentrega
 * @property bool $consignacion
 * @property string $marca1
 * @property string $marca2
 * @property string $marca3
 * @property string $marca4
 * @property string $marca5
 * @property string $marca6
 * @property string $link_marca1
 * @property string $link_marca2
 * @property string $link_marca3
 * @property string $link_marca4
 * @property string $link_marca5
 * @property string $link_marca6
 * @property string $telefono
 * @property bool $wizard
 * @property-read \Illuminate\Support\Collection $sliders
 * @property-read \App\Models\Vendty\DBConfig $dbConfig
 * @property-read \App\Models\Shop\Warehouse $warehouse
 * @property-read \App\Models\Vendty\Template $template
 * @mixin \Eloquent
 */
class Shop extends Model
{
    /**
     * [$table description]
     * @var string
     */
    protected $table = 'tienda';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_db', 'id_almacen', 'dominio_local', 'shopname', 'layout', 'description', 'activo', 'seo_description', 'seo_keywords', 'logo', 'google_map', 'google_analytics', 'slider1', 'slider2', 'slider3', 'slider4', 'slider5', 'slider6', 'merchantId', 'accountId', 'ApiKey', 'cuentabancaria', 'nombrebanco', 'tipocuenta', 'nombretitular', 'correo', 'imagenQuienesSomos1', 'imagenQuienesSomos2', 'descripcionQuienesSomos', 'tituloQuienesSomos', 'apikeyEPayco', 'publickeyEPayco', 'idClienteEPayco', 'terminos_condiciones_titulo', 'terminos_condiciones', 'propiedad_intelectual_titulo', 'propiedad_intelectual', 'cambios_devoluciones_titulo', 'cambios_devoluciones', 'tratamiento_datos_titulo', 'tratamiento_datos', 'fondo', 'logo_inferior', 'favicon', 'stock_almacen', 'cobro_envios', 'menu_estatico', 'color_fondo_menu', 'color_letra_menu', 'color_fondo_pie_pagina', 'color_letra_pie_pagina', 'dominio', 'productos_destacados', 'productos_recientes', 'link_slider1', 'link_slider2', 'link_slider3', 'link_slider4', 'link_slider5', 'link_slider6', 'imagen_parallax', 'texto_parallax', 'texto_boton_parallax', 'link_parallax', 'contraentrega', 'consignacion', 'epayco', 'marca1', 'marca2', 'marca3', 'marca4', 'marca5', 'marca6', 'link_marca1', 'link_marca2', 'link_marca3', 'link_marca4', 'link_marca5', 'link_marca6', 'telefono', 'wizard'
    ];

    /**
     * Deshabilitamos los campos created_at y updated_at
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getSlidersAttribute()
    {
        $sliders = collect([]);
        if (!is_null($this->slider1)) {
            $sliders->push($this->slider1);
        }

        if (!is_null($this->slider2)) {
            $sliders->push($this->slider2);
        }

        if (!is_null($this->slider3)) {
            $sliders->push($this->slider3);
        }

        if (!is_null($this->slider4)) {
            $sliders->push($this->slider4);
        }

        if (!is_null($this->slider5)) {
            $sliders->push($this->slider5);
        }

        if (!is_null($this->slider6)) {
            $sliders->push($this->slider6);
        }

        return $sliders;
    }

    /**
     * @param string|null $value
     */
    public function setDominioAttribute(string $value = null)
    {
        if (!is_null($value)) {
            $domain = parse_shop_domain($value);
            Domain::process($domain);

            $this->attributes['dominio'] = $domain;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dbConfig()
    {
        return $this->belongsTo(DBConfig::class, 'id_db');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'id_almacen');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function template()
    {
        return $this->hasOne(Template::class, 'nombre', 'layout');
    }
}
