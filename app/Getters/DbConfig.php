<?php

namespace App\Getters;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Trait DbConfig
 * @package App\Getters\Vendty
 * @property-read bool $is_pay
 * @property-read bool $is_demo
 * @property-read bool $is_new
 * @property-read Collection $all_licenses
 * @property-read Collection $all_licenses_active
 * @property-read Collection $all_licenses_expired
 * @property-read Collection $all_licenses_expired_not_deactivated
 * @property-read Collection $all_licenses_expired_deactivated
 */
trait DbConfig
{
    /**
     * @return bool
     */
    public function getIsDemoAttribute(): bool
    {
        return $this->estado === 2;
    }

    /**
     * Todas mis licencias
     *
     * @return Collection
     */
    public function getAllLicensesAttribute(): Collection
    {
        return $this->viewLicenses->whereNotIn('id_plan', [15, 16, 17]);
    }
}

