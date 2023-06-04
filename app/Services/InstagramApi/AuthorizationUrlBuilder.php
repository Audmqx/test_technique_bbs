<?php

namespace App\Services\InstagramApi;

class AuthorizationUrlBuilder
{
    private $clientID;
    private $redirectUri;

    public function setClientId(string $clientID): void
    {
        $this->clientID = $clientID;
    }

    public function setRedirectUri(string $uri): void
    {
        $this->redirectUri = $uri;
    }

    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }

    public function getConstructedUrl(): string
    {
        return "https://api.instagram.com/oauth/authorize?client_id=".$this->clientID."&redirect_uri=".$this->redirectUri."&scope=user_profile,user_media&response_type=code";
    }
}