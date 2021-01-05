<?php

namespace App\Exports;

use App\Models\Shop\OnlineSaleProd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DateTime;

class OnlineSalesExport implements FromCollection, WithMapping, WithHeadings
{
    protected $initialDate;
    protected $finalDate;

    public function __construct($initialDate, $finalDate)
    {
        $this->initialDate = $initialDate;
        $this->finalDate = $finalDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if (($this->initialDate && $this->initialDate !== '') || ($this->finalDate && $this->finalDate !== '')){
            $initialDate = new DateTime($this->initialDate);
            $initialDate = $initialDate->format('Y-m-d H:i:s');
            $finalDate = new DateTime($this->finalDate);
            $finalDate = $finalDate->format('Y-m-d H:i:s');
            $orders = OnlineSaleProd::whereBetween('created_at', [$initialDate, $finalDate])
            ->get();

        } else {
            $orders = OnlineSaleProd::all();
        }

        return $orders;
    }

    /**
    * @var OnlineSale $onlineSale
    */
    public function map($onlineSaleProd): array
    {
        return [
            $onlineSaleProd->onlineVenta->id,
            $onlineSaleProd->onlineVenta->dni,
            $onlineSaleProd->onlineVenta->nombre,
            $onlineSaleProd->onlineVenta->movil,
            $onlineSaleProd->onlineVenta->email,
            $onlineSaleProd->onlineVenta->direccion,
            $onlineSaleProd->onlineVenta->poblacion,
            $onlineSaleProd->onlineVenta->sub_total,
            $onlineSaleProd->onlineVenta->fecha,
            $onlineSaleProd->descripcion,
            $onlineSaleProd->cantidad,
            $onlineSaleProd->total,
            $onlineSaleProd->onlineVenta->present()->orderStatus(),
            $onlineSaleProd->onlineVenta->metodo_pago
        ];
    }

    public function headings(): array
    {
        return [
            'Nro Orden',
            'Documento',
            'Nombre',
            'Telefono',
            'Correo',
            'Dirreccion',
            'Ciudad',
            'Pago',
            'Fecha',
            'Producto',
            'Cantidad',
            'Precio',
            'Estado',
            'Metodo Pago',
        ];
    }
}
