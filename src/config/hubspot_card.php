<?php

return [
    'jwt_secret' => env('HUBSPOT_CARD_JWT_SECRET'),
    'expire_in_minutes' => env('HUBSPOT_CARD_TOKEN_ACTIVE_MINUTES', 30),
    'hubspot_client_secret' => env('HUBSPOT_CLIENT_SECRET')
];
