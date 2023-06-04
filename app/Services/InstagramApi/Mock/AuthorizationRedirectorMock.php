<?php

namespace App\Services\InstagramApi\Mock;

class AuthorizationRedirectorMock
{
    public static function redirectToInstagramAuthorisation(string $url = "") :string
    {
        return "http://audmqx.github.io/test_technique_bbs/instagram/auth?code=authCode";
    }
}