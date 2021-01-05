<?php

namespace App\Setters;

/**
 * Trait Product
 * @package App\Setters
 * @property int $category
 * @property string|null $code
 * @property string $name
 * @property float|null $buy_price
 * @property float|null $sale_price
 * @property bool|null $sell_in_negative
 * @property bool|null $show_stock
 * @property string|null $description
 * @property string|null $long_description
 * @property bool|null $featured
 */
trait Product
{
    /**
     * @param int|null $value
     */
    public function setCategoryAttribute(int $value = null)
    {
        $this->attributes['categoria_id'] = $value;
    }

    /**
     * @param string|null $value
     */
    public function setCodeAttribute(string $value = null)
    {
        $this->attributes['codigo'] = $value;
    }

    /**
     * @param string|null $value
     */
    public function setNameAttribute(string $value = null)
    {
        $this->attributes['nombre'] = $value;
    }

    /**
     * @param float|null $value
     */
    public function setBuyPriceAttribute(float $value = null)
    {
        $this->attributes['precio_compra'] = $value;
    }

    /**
     * @param float|null $value
     */
    public function setSalePriceAttribute(float $value = null)
    {
        $this->attributes['precio_venta'] = $value;
    }

    /**
     * @param bool|null $value
     */
    public function setSellInNegativeAttribute(bool $value = null)
    {
        $this->attributes['vendernegativo'] = $value;
    }

    /**
     * @param bool|null $value
     */
    public function setShowStockAttribute(bool $value = null)
    {
        $this->attributes['mostrar_stock'] = $value;
    }

    /**
     * @param string|null $value
     */
    public function setDescriptionAttribute(string $value = null)
    {
        $this->attributes['descripcion'] = $value;
    }

    /**
     * @param string|null $value
     */
    public function setLongDescriptionAttribute(string $value = null)
    {
        $this->attributes['descripcion_larga'] = $value;
    }

    /**
     * @param bool|null $value
     */
    public function setFeaturedAttribute(bool $value = null)
    {
        $this->attributes['destacado_tienda'] = $value;
    }
}
