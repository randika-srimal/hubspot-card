<?php

namespace RandikaSrimal\HubspotCard\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hubspot-card:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the HubSpot Card controllers and resources';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        if (!file_exists(config_path('hubspot_card.php'))) {
            copy(__DIR__ . '/../../config/hubspot_card.php', config_path('hubspot_card.php'));
        }

        if (!file_exists(app_path('Http/Controllers/HubspotCardController.php'))) {
            copy(__DIR__ . '/../../Controllers/HubspotCardController.php', app_path('Http/Controllers/HubspotCardController.php'));
        }

        if (!file_exists(resource_path('views/hubspot-card/index.blade.php'))) {
            copy(__DIR__ . '/../../resources/views/index.blade.php', resource_path('views/hubspot-card/index.blade.php'));
        }

        if (!file_exists(base_path('routes/hubspot-card.php'))) {
            copy(__DIR__ . '/../../routes/hubspot-card.php', base_path('routes/hubspot-card.php'));

            $requireRoutes = "require __DIR__.'/hubspot-card.php';";
            file_put_contents(base_path('routes/web.php'), PHP_EOL.$requireRoutes.PHP_EOL , FILE_APPEND | LOCK_EX);
        }

        return 1;
    }
}
