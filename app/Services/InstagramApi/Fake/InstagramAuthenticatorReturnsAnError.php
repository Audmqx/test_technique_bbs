<?php

namespace App\Services\InstagramApi\Fake;

use App\Services\InstagramApi\InstagramAuthenticator;

class InstagramAuthenticatorReturnsAnError extends InstagramAuthenticator
{
    public function getToken()
    {
        return [
            'error_message' => 'Invalid authorization code',
            'error_type' => 'OAuthException',
            "code" => 400];
    }
}