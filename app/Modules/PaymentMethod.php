<?php
/**
 * Created by adminshop.
 * User: Rafael Moreno
 * Date: 22/11/2018
 * Time: 11:20 AM
 */

namespace App\Modules;

use App\Models\Shop\PaymentMethod\EPayco;
use App\Models\Shop\PaymentMethod\MercadoPago;
use App\Models\Shop\PaymentMethod\OpenPay;
use App\Models\Shop\PaymentMethod\PayU;
use App\Models\Shop\PaymentMethod\Kushki;
use App\Models\Shop\PaymentMethod\Paymentez;
use App\Models\Shop\PaymentMethod\PayPal;
use App\Models\Shop\PaymentMethod\Wompi;

/**
 * Class PaymentMethod
 * @package App\Modules
 */
class PaymentMethod
{
    /**
     * Desactivamos todos los metodos de pago
     */
    public function disablePayment()
    {
        $this->disableEpayco();
        $this->disablePayU();
        $this->disableMercadopago();
        $this->disableOpenPay();
        $this->disableKushki();
        $this->disablePaymentez();
        $this->disablePaypal();
        $this->disableWompi();
    }

    /**
     * @return bool
     */
    private function disableEpayco()
    {
        $epayco = EPayco::first();

        if (!is_null($epayco)) {
            $epayco->active = false;

            return $epayco->save();
        }

        return false;
    }

    /**
     * @return bool
     */
    private function disablePayU()
    {
        $payu = PayU::first();

        if (!is_null($payu)) {
            $payu->active = false;

            return $payu->save();
        }

        return false;
    }

    /**
     * @return bool
     */
    private function disableMercadopago()
    {
        $mercadopago = MercadoPago::first();

        if (!is_null($mercadopago)) {
            $mercadopago->active = false;

            return $mercadopago->save();
        }

        return false;
    }

    /**
     * @return bool
     */
    private function disableOpenPay()
    {
        $openpay = OpenPay::first();

        if (!is_null($openpay)) {
            $openpay->active = false;

            return $openpay->save();
        }

        return false;
    }

    /**
     * @return bool
     */
    private function disableKushki()
    {
        $kushki = Kushki::first();

        if (!is_null($kushki)) {
            $kushki->active = false;

            return $kushki->save();
        }

        return false;
    }

    /**
     * @return bool
     */
    private function disablePaypal()
    {
        $paypal = PayPal::first();

        if (!is_null($paypal)) {
            $paypal->active = false;

            return $paypal->save();
        }

        return false;
    }

    /**
     * @return bool
     */
    private function disableWompi()
    {
        $wompi = Wompi::first();

        if (!is_null($wompi)) {
            $wompi->active = false;

            return $wompi->save();
        }

        return false;
    }

    /**
     * @return bool
     */
    private function disablePaymentez()
    {
        $paymentez = Paymentez::first();

        if (!is_null($paymentez)) {
            $paymentez->active = false;

            return $paymentez->save();
        }

        return false;
    }
}
