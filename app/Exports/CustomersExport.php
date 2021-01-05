<?php

namespace App\Exports;

use App\Models\Shop\Customer;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::all();
    }

     /**
    * @var Customer $customer
    */
    public function map($customer): array
    {
        return [
            $customer->nif_cif,
            $customer->nombre_comercial,
            $customer->movil,
            $customer->email,
            $customer->direccion,
            $customer->poblacion,
        ];
    }

    public function headings(): array
    {
        return [
            'Documento',
            'Nombre',
            'Telefono',
            'Correo',
            'Dirreccion',
            'Ciudad',
        ];
    }
}
