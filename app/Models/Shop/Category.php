<?php

namespace App\Models\Shop;

use App\Presenters\Category as CategoryPresenter;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App\Models\Shop
 * @property-read integer $id
 * @property string $codigo
 * @property string $nombre
 * @property string $imagen
 * @property integer $padre
 * @property bool $activo
 * @property bool $es_menu_principal_tienda
 * @property bool $tienda
 * @property-read \App\Models\Shop\Category[]|\Illuminate\Support\Collection $subcategories
 * @property-read \App\Models\Shop\Category $fathery
 * @mixin \Eloquent
 */
class Category extends Model
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
    protected $table = 'categoria';

    /**
     * @var array
     */
    protected $attributes = [
        'tienda' => true
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo', 'nombre', 'imagen', 'padre', 'activo', 'es_menu_principal_tienda', 'tienda'
    ];

    /**
     * Deshabilitamos los campos created_at y updated_at
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'padre')->where([['tienda', true], ['activo', true]]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function father()
    {
        return $this->belongsTo(Category::class, 'padre');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'categoria_id');
    }

    /**
     * @return CategoryPresenter
     */
    public function present()
    {
        return new CategoryPresenter($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getSubcategoriesStringAttribute()
    {
        $subcategories = '';

        foreach ($this->subcategories as $subcategory) {
            $subcategories .= $subcategory->nombre . ',';
        }

        return $subcategories;
    }
}
