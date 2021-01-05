<?php

namespace App\Providers;

use App\Modules\PaymentMethod;
use Illuminate\Support\ServiceProvider;

class PaymentMethodServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('payment.method', function () {
            return new PaymentMethod;
        });
    }
}
