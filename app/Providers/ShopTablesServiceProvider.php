<?php

namespace App\Providers;

use App\Database\Tables;
use Illuminate\Support\ServiceProvider;

class ShopTablesServiceProvider extends ServiceProvider
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
        $this->app->singleton('shoptables', function ($app) {
            return new Tables();
        });
    }
}
