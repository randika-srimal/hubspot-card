<?php
namespace RandikaSrimal\HubspotCard\Controllers;

use RandikaSrimal\HubspotCard\HubspotCard;

class HubspotCardController
{
    public function index() {
        return view('hubspot-card::index');
    }

    public function data(HubspotCard $hubspotCard) {
        return response()->json($hubspotCard->getCardData(1), 200);
    }
}