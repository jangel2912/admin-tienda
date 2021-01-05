<?php

namespace App\Imports;

use App\Models\Shop\Shipping;
use Maatwebsite\Excel\Concerns\ToArray;

class ShippingImport implements ToArray
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function array(array $rows)
    {
        foreach ($rows as $row) {
            $shipping = new Shipping;
            $shipping->origen = $row[0];
            $shipping->destino = $row[1];
            $shipping->valor = $row[2];
            $shipping->save();
        }
    }
}
