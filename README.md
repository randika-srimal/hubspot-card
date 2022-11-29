# HubSpot Card Boilerplate for Laravel

## How to install the package

1. Install the composer package by executing `composer require randika-srimal/hubspot-card`.

2. Open project terminal and execute `php artisan hubspot-card:install`. This will add the required routes, controllers and resources to your project.

3. HubSpot Card data get route is `/hubspot-card/data`. Card view will be available at `/hubspot-card`. You may change these if required.

### Important

Below .env properties can be used to extend HubSpot Card functionality.

1. `HUBSPOT_CARD_JWT_SECRET` : Setting this will add JWT security to card view URL.
2. `HUBSPOT_CARD_TOKEN_ACTIVE_MINUTES` : The JWT will be expire after the minutes you set here. Default is 30 minutes.
3. `HUBSPOT_CLIENT_SECRET` : Setting this will enable HubSpot request verification.

