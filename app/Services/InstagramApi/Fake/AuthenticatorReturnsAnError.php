<?php

namespace App\Services\InstagramApi\Fake;

use App\Services\InstagramApi\Authenticator;

class AuthenticatorReturnsAnError extends Authenticator
{
    public function execute()
    {
        return [
            'error_message' => 'Invalid authorization code',
            'error_type' => 'OAuthException',
            "code" => 400];
    }
}