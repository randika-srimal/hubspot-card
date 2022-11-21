<?php

namespace EIO\HubspotCard\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use EIO\HubspotCard\Console\Commands\InstallCommand;

class HubspotCardServiceProvider extends ServiceProvider
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