<?php

namespace App\Services\InstagramApi;

use GuzzleHttp\Client;


class InstagramAuthenticator
    {
    public function getUrl()
    {
        return "https://api.instagram.com/oauth/access_token";
    }

    public function getData(string $code): array
    {
        return ['client_id' => config('services.instagram.app_id'),
                'client_secret' => config('services.instagram.app_secret'),
                'grant_type' => 'authorization_code',
                'redirect_uri' => config('services.instagram.redirect_uri'),
                'code' => $code,
                ];
    }

    public function exchangeAuthorizationCodeToToken($response)
    {
        if ($response->getStatusCode() != 200) {
            return $response->getBody();
        }

        return json_decode($response->getBody(), true);
    }
}