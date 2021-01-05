<?php

namespace App\Setters;

use Illuminate\Support\Collection;

/**
 * Trait Promotion
 * @package App\Setters
 * @property string $name
 * @property string $initial_date
 * @property string $final_date
 * @property string $initial_time
 * @property string $final_time
 * @property \Illuminate\Support\Collection $days
 * @property bool $active
 */
trait Promotion
{
    /**
     * @param string $value
     */
    public function setNameAttribute(string $value)
    {
        $this->attributes['nombre'] = $value;
    }

    /**
     * @param string $value
     */
    public function setInitialDateAttribute(string $value)
    {
        $this->attributes['fecha_inicial'] = $value;
    }

    /**
     * @param string $value
     */
    public function setFinalDateAttribute(string $value)
    {
        $this->attributes['fecha_final'] = $value;
    }

    /**
     * @param string $value
     */
    public function setInitialTimeAttribute(string $value)
    {
        $this->attributes['hora_inicio'] = $value;
    }

    /**
     * @param string $value
     */
    public function setFinalTimeAttribute(string $value)
    {
        $this->attributes['hora_fin'] = $value;
    }

    /**
     * @param Collection $value
     */
    public function setDaysAttribute(Collection $value)
    {
        $this->attributes['dias'] = $value->implode(',');
    }

    /**
     * @param bool $value
     */
    public function setActiveAttribute(bool $value)
    {
        $this->attributes['activo'] = $value;
    }
}
