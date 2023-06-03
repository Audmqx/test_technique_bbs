<?php

namespace App\Services\InstagramApi;

class InstagramAuthorizationRedirector
{
    public function redirectToInstagramAuthorisation(string $url): void
    {
        header("Location: ".$url);
        exit;
    }
}