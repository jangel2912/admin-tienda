<?php

namespace App\Providers;

use App\Repositories\Vendty\Shop;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('repository.vendty.shop', function () {
            return new Shop;
        });
    }
}
