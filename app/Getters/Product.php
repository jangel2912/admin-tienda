<?php

namespace App\Getters;

/**
 * Trait Product
 * @package App\Getters
 * @property string|null $code
 * @property string $name
 * @property float|null $buy_price
 * @property float|null $sale_price
 * @property bool|null $sell_in_negative
 * @property bool|null $show_stock
 * @property string|null $description
 * @property string|null $long_description
 * @property bool|null $featured
 * @property-read \Illuminate\Support\Collection $images
 */
trait Product
{
    /**
     * @return string|null
     */
    public function getCodeAttribute()
    {
        return $this->codigo;
    }

    /**
     * @return string|null
     */
    public function getNameAttribute()
    {
        return !is_null($this->reference) ? $this->reference->nombre : $this->nombre;
    }

    /**
     * @return string|null
     */
    public function getAttributesAttribute()
    {
        return !is_null($this->reference) ? str_replace($this->reference->nombre . '/', '', $this->nombre) : null;
    }

    /**
     * @return float|null
     */
    public function getBuyPriceAttribute()
    {
        return $this->precio_compra;
    }

    /**
     * @return float|null
     */
    public function getSalePriceAttribute()
    {
        return $this->precio_venta;
    }

    /**
     * @return float|null
     */
    public function getPriceAttribute()
    {
        $percentage = !is_null($this->tax) ? $this->tax->porciento : 0;

        return round($this->precio_venta * (1 + ($percentage / 100)), 2);
    }

    /**
     * @return bool|null
     */
    public function getSellInNegativeAttribute()
    {
        return $this->vendernegativo;
    }

    /**
     * @return bool|null
     */
    public function getShowStockAttribute()
    {
        return $this->mostrar_stock;
    }

    /**
     * @return string|null
     */
    public function getDescriptionAttribute()
    {
        return !is_null($this->reference) ? $this->reference->descripcion : $this->descripcion;
    }

    /**
     * @return string|null
     */
    public function getLongDescriptionAttribute()
    {
        return !is_null($this->reference) ? $this->reference->descripcion_larga : $this->descripcion_larga;
    }

    /**
     * @return bool|null
     */
    public function getFeaturedAttribute()
    {
        return $this->destacado_tienda;
    }

    /**
     * Get the product's image.
     *
     * @return string
     */
    public function getImageAttribute()
    {
        return !is_null($this->reference) ? $this->reference->imagen : $this->imagen;
    }

    /**
     * Get the product's image.
     *
     * @return string
     */
    public function getImage1Attribute()
    {
        return !is_null($this->reference) ? $this->reference->imagen1 : $this->imagen1;
    }

    /**
     * Get the product's image.
     *
     * @return string
     */
    public function getImage2Attribute()
    {
        return !is_null($this->reference) ? $this->reference->imagen2 : $this->imagen2;
    }

    /**
     * Get the product's image.
     *
     * @return string
     */
    public function getImage3Attribute()
    {
        return !is_null($this->reference) ? $this->reference->imagen3 : $this->imagen3;
    }

    /**
     * Get the product's image.
     *
     * @return string
     */
    public function getImage4Attribute()
    {
        return !is_null($this->reference) ? $this->reference->imagen4 : $this->imagen4;
    }

    /**
     * Get the product's image.
     *
     * @return string
     */
    public function getImage5Attribute()
    {
        return !is_null($this->reference) ? $this->reference->imagen5 : $this->imagen5;
    }

    /**
     * Get the product's image.
     *
     * @return string
     */
    public function getHasImagesAttribute()
    {
        return $this->imagen || $this->imagen1 || $this->imagen2 || $this->imagen3 || $this->imagen4 || $this->imagen5;
    }
}
