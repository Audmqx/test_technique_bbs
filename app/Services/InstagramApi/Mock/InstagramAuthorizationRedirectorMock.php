<?php

namespace App\Services\InstagramApi\Mock;

class InstagramAuthorizationRedirectorMock
{
    public static function redirectToInstagramAuthorisation(string $url = "") :string
    {
        return "https://audmqx.github.io/test_technique_bbs/auth?code=authCode";
    }
}