<?php

namespace App\Getters\Views;

/**
 * Trait License
 * @package App\Getters\Vendty\Views
 * @property-read bool $is_active
 * @property-read bool $is_deactivated
 * @property-read bool $is_trial
 */
trait License
{
    /**
     * @return bool
     */
    public function getIsActiveAttribute()
    {
        return $this->estado_licencia === 1;
    }

    /**
     * @return bool
     */
    public function getIsDeactivatedAttribute()
    {
        return $this->estado_licencia === 2;
    }

    /**
     * @return bool
     */
    public function getIsTrialAttribute()
    {
        return $this->estado_licencia === 15;
    }
}