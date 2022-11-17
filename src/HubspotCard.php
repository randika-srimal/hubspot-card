<?php

namespace RandikaSrimal\HubspotCard;

class HubspotCard
{
    public function getCardData($objectId)
    {
        return [
            'results' => [
                [
                    'objectId' => $objectId, //$request->associatedObjectId,
                    'title' => 'HubSpot Sample Card',
                    'summary' => 'Sample Card Summary',
                ]
            ],
            'primaryAction' => [
                "type" => "IFRAME",
                "width" => 890,
                "height" => 748,
                "uri" => '/hubspot-card',
                "label" => "Open Card"
            ]
        ];;
    }
}
