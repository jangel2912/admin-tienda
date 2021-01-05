<?php

namespace App\Presenters;

use App\Presenters\Abstracts\Presenter;

/**
 * Class OnlineSale
 * @package App\Presenters
 */
class OnlineSale extends Presenter
{
    /**
     * @return string
     */
    public function orderStatus()
    {
        switch ($this->model->estado) {
            case 0: return 'Atendida'; break;
            case 1: return 'Aprobada'; break;
            case 2: return 'Rechazada'; break;
            case 3: return 'Pendiente pago'; break;
            case 4: return 'Pendiente pago'; break;
            case 11: return 'Atendida'; break;
            case 12: return 'Anulada'; break;
            case 13: return 'Facturada'; break;
        }
    }

    /**
     * @return string
     */
    public function subTotal()
    {
        return number_format($this->model->sub_total, 2);
    }
}
