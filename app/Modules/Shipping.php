<?php
/**
 * Created by adminshop.
 * User: Rafael Moreno
 * Date: 16/11/2018
 * Time: 9:06 AM
 */

namespace App\Modules;

use App\Models\Shop\Shipping\AllFree;
use App\Models\Shop\Shipping\FreeFrom;

/**
 * Class Shipping
 * @package App\Modules
 */
class Shipping
{
    /**
     * @param bool $active
     * @return bool
     */
    public function setAllFree(bool $active)
    {
        $allFree = AllFree::first();
        if (is_null($allFree)) {
            $allFree = new AllFree;
        }

        if ($this->disableFreeFrom()) {
            $allFree->activo = $active;

            return $allFree->save();
        }

        return false;
    }

    /**
     * @return bool
     */
    private function disableFreeFrom()
    {
        $freeFrom = FreeFrom::first();
        if (is_null($freeFrom)) {
            $freeFrom = new FreeFrom;
        }

        $freeFrom->activo = false;

        return $freeFrom->save();
    }
}
