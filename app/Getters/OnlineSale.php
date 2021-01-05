<?php

namespace App\Getters;

/**
 * Trait OnlineSale
 * @package App\Getters
 * @property-read string $full_name
 */
trait OnlineSale
{
    /**
     * @return string
     */
    public function getFullName()
    {
        return "{$this->nombre} {$this->apellidos}";
    }
}
