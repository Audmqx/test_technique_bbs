<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class InstagramApi
{
    private $redirectUri;
    private $clientID;
    private $appSecret;

    public function setClientId(string $clientID) :void
    {
        $this->clientID = $clientID;
    }

    public function setRedirectUri(string $uri) :void
    {
        $this->redirectUri = $uri;
    }

    public function setAppSecret(string $appSecret) :void
    {
        $this->appSecret = $appSecret;
    }

    public function getConstructedUrl() :string
    {
        return "https://api.instagram.com/oauth/authorize?client_id=".$this->clientID."&redirect_uri=".$this->redirectUri."&scope=user_profile,user_media&response_type=code";
    }

    public function redirectToInstagramAuthorisation()
    {
        header("Location:". $this->getConstructedUrl());
    }

    public function getCode(string $url)
    {
        if ($this->isCallbackURLContainsUri($url) && $this->isCallbackURLContainsCodeParameter($url)) {
            $queryParameters = $this->parseUrl($url);
            return $queryParameters['code'];
        }

        return false;
    }

    public function isCallbackURLContainsUri(string $callbackURL) :bool
    {
        return  strpos($callbackURL, $this->redirectUri) !== false ? true : false;
    }

    public function isCallbackURLContainsCodeParameter(string $url) :bool
    {
        $queryParameters = $this->parseUrl($url);

        //we are looking for code get parameter because it is returned by the instagram api
        if (isset($queryParameters['code']) && !empty($queryParameters['code'])) {
            return true;
        }

        return false;
    }

    private function parseUrl(string $url) :array
    {
        $parsedUrl = parse_url($url);
        parse_str($parsedUrl['query'], $queryParameters);

        return $queryParameters;
    }
}