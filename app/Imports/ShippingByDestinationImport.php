<?php

namespace App\Imports;

use App\Models\Shop\Shipping\ByDestination;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShippingByDestinationImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|void|null
     */
    public function model(array $row)
    {
        if (!is_null($row['destino']) && !is_null($row['valor'])) {
            $byDestination = new ByDestination;
            $byDestination->origen = auth_user()->dbConfig->shop->warehouse->ciudad;
            $byDestination->destino = $row['destino'];
            $byDestination->valor = $row['valor'];
            $byDestination->save();
        }
    }
}
