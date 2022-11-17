<?php

namespace RandikaSrimal\HubspotCard\Providers;

use Illuminate\Support\ServiceProvider;

class HubspotCardProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../views', 'hubspot-card');
    }
}