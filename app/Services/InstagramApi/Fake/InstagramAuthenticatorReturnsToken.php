<?php

namespace App\Services\InstagramApi\Fake;

use App\Services\InstagramApi\InstagramAuthenticator;

class InstagramAuthenticatorReturnsToken extends InstagramAuthenticator
{
    public function getToken()
    {
      return [
                "access_token" => "0000000000000",
                "user_id" => 0000000000000000
            ];
    }
}