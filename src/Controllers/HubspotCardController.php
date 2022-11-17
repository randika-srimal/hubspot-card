<?php
namespace RandikaSrimal\HubspotCard\Controllers;

use RandikaSrimal\HubspotCard\HubspotCard;
use Illuminate\Http\Request;

class HubspotCardController
{
    public function index() {
        return view('hubspot-card::index');
    }

    public function data(HubspotCard $hubspotCard, Request $request) {
        return response()->json($hubspotCard->getCardData($request->associatedObjectId), 200);
    }
}