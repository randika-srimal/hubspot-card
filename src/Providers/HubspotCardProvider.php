<?php

namespace RandikaSrimal\HubspotCard\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use RandikaSrimal\HubspotCard\Console\Commands\InstallCommand;

class HubspotCardProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
        
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/hubspot-card.php'));
        });
        
    }
}