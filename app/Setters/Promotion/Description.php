<?php

namespace App\Setters\Promotion;

use App\Models\Shop\Promotion\Promotion;

/**
 * Trait Description
 * @package App\Setters\Promotion
 * @property \App\Models\Shop\Promotion\Promotion $promotion
 * @property integer $rule_index
 * @property integer $qty
 * @property integer $discount
 */
trait Description
{
    /**
     * @param Promotion $value
     */
    public function setPromotionAttribute(Promotion $value)
    {
        $this->attributes['id_promocion'] = $value->id;
    }

    /**
     * @param int $value
     */
    public function setRuleIndexAttribute(int $value)
    {
        $this->attributes['producto_pos'] = $value;
    }

    /**
     * @param int $value
     */
    public function setQtyAttribute(int $value)
    {
        $this->attributes['cantidad'] = $value;
    }

    /**
     * @param int $value
     */
    public function setDiscountAttribute(int $value)
    {
        $this->attributes['descuento'] = $value;
    }
}
