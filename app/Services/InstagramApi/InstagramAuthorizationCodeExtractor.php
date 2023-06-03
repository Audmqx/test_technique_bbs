<?php

namespace App\Services\InstagramApi;

use App\Traits\UrlParser;

class InstagramAuthorizationCodeExtractor
{
    use UrlParser;

    private $redirectUri;

    public function __construct(string $redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    public function getCode($url): ?string
    {
        if ($this->isCallbackURLContainsUri($url) && $this->isCallbackURLContainsCodeParameter($url)) {
            $queryParameters = $this->parseUrl($url);
            return $queryParameters['code'];
        }

        return null;
    }

    public function isCallbackURLContainsUri(string $callbackURL): bool
    {
        return strpos($callbackURL, $this->redirectUri) !== false;
    }

    public function isCallbackURLContainsCodeParameter(string $url): bool
    {
        $queryParameters = $this->parseUrl($url);
        return isset($queryParameters['code']) && !empty($queryParameters['code']);
    }
}