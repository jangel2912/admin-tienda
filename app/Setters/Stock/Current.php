<?php

namespace App\Setters\Stock;

/**
 * Trait Current
 * @package App\Setters\Stock
 * @property-write integer $set_warehouse
 * @property-write integer $set_product
 * @property-write integer $set_quantity
 */
trait Current
{
    /**
     * @param int $value
     */
    public function setSetWarehouseAttribute(int $value)
    {
        $this->attributes['almacen_id'] = $value;
    }

    /**
     * @param int $value
     */
    public function setSetProductAttribute(int $value)
    {
        $this->attributes['producto_id'] = $value;
    }

    /**
     * @param int $value
     */
    public function setSetQuantityAttribute(int $value)
    {
        $this->attributes['unidades'] = $value;
    }
}
