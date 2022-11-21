<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HubspotCardController;

Route::prefix('hubspot-card')->group(function () {
    Route::get('', [HubspotCardController::class, 'index']);
    Route::get('data', [HubspotCardController::class, 'data']);
});