<?php

namespace App\Services\InstagramApi;

use App\Traits\UrlParser;

class InstagramAuthorizationCodeExtractor
{
    use UrlParser;

    public function getCode($url)
    {
        if ($this->isCallbackURLContainsCodeParameter($url)) {
            $queryParameters = $this->parseUrl($url);
            return $queryParameters['code'];
        }
    }


    public function isCallbackURLContainsCodeParameter(string $url): bool
    {
        $queryParameters = $this->parseUrl($url);
        return isset($queryParameters['code']) && !empty($queryParameters['code']);
    }
}