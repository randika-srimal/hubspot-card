<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class HubspotCardController
{
    public function index(Request $request)
    {
        try {

            $tokenPayload = [];

            if (!empty(config('hubspot_card.jwt_secret'))) {
                $request->validate(['card-token' => 'required']);

                $tokenPayload = $this->validateHubSpotJWT($request->get('card-token'));
            }

            return view('hubspot-card.index', ['tokenPayload' => $tokenPayload]);
        } catch (\Throwable $th) {
            return response()->json(['error' => ["code" => 401, "message" => $th->getMessage()]], 401);
        }
    }

    public function data(Request $request)
    {
        if (!empty(config('hubspot_card.hubspot_client_secret'))) {
            $isHubspotRequest = $this->verifyRequest($request);

            if (!$isHubspotRequest) {
                return response()->json([
                    'results' => [
                        [
                            'objectId' => $request->associatedObjectId,
                            'title' => 'Error - Please get admin to log in and correct account issues',
                        ]
                    ]
                ], 200);
            }
        }

        $uri = "/hubspot-card";

        if (!empty(config('hubspot_card.jwt_secret'))) {
            $jwtToken = $this->generateJWTForHubSpotCard($request);
            $uri .= "?card-token={$jwtToken}";
        }

        $cardData = [
            'results' => [
                [
                    'objectId' => $request->associatedObjectId,
                    'title' => 'HubSpot Sample Card',
                    'summary' => 'Sample Card Summary',
                ]
            ],
            'primaryAction' => [
                "type" => "IFRAME",
                "width" => 890,
                "height" => 748,
                "uri" => $uri,
                "label" => "Open Card"
            ]
        ];


        return response()->json($cardData, 200);
    }

    private function verifyRequest(Request $request): bool
    {
        $entityBody = file_get_contents('php://input');

        $signatureVersion = $request->header('X-HubSpot-Signature-Version');

        if ($signatureVersion == 'v2') {
            if ($entityBody) {
                $request_to_hash = config('hubspot_card.hubspot_client_secret') . $_SERVER['REQUEST_METHOD'] . "https://$_SERVER[HTTP_HOST]" . "$_SERVER[REQUEST_URI]" . $entityBody;
            } else {
                $request_to_hash = config('hubspot_card.hubspot_client_secret') . $_SERVER['REQUEST_METHOD'] . "https://$_SERVER[HTTP_HOST]" . "$_SERVER[REQUEST_URI]";
            }
        } else if ($signatureVersion == 'v1') {
            if ($entityBody) {
                $request_to_hash = config('hubspot_card.hubspot_client_secret') . $entityBody;
            } else {
                $request_to_hash = config('hubspot_card.hubspot_client_secret');
            }
        }

        $hash_to_test_against_header = hash('sha256', $request_to_hash);
        $header_hash = $request->header('X-HubSpot-Signature');

        if ($header_hash && $header_hash == $hash_to_test_against_header) {
            return true;
        }

        return false;
    }

    private function generateJWTForHubSpotCard(Request $request): string
    {
        $currentTime = now(config('app.timezone'));

        $secretKey  = config('hubspot_card.jwt_secret');
        $issuedAt   = $currentTime->getTimestamp();
        $expire     = $currentTime->addMinutes(config('hubspot_card.expire_in_minutes'))->getTimestamp();
        $serverName = config('app.url');

        $data = [
            'iat'  => $issuedAt,
            'iss'  => $serverName,
            'nbf'  => $issuedAt,
            'exp'  => $expire,
            'requestingUserId' => $request->userId,
            'requestingUserEmail' => $request->userEmail,
            'associatedObjectType' => $request->associatedObjectType,
            'associatedObjectId' => $request->associatedObjectId,
        ];

        $jwt = JWT::encode(
            $data,
            $secretKey,
            'HS512'
        );

        return $jwt;
    }

    private function validateHubSpotJWT($token)
    {
        if (!empty($token)) {
            $jwtToken = $token;
        } else {
            throw new Exception("Sorry, you are not allowed to perform this action.", 401);
        }

        $secretKey  = config('hubspot_card.jwt_secret');
        $payload = JWT::decode($jwtToken, new Key($secretKey, 'HS512'));

        return [
            'associatedObjectType' => $payload->associatedObjectType,
            'associatedObjectId' => $payload->associatedObjectId,
            'requestingUserId' => $payload->requestingUserId,
            'requestingUserEmail' => $payload->requestingUserEmail
        ];
    }
}
