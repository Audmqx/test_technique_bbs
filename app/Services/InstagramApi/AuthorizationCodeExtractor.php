<?php

namespace App\Services\InstagramApi;

use App\Traits\UrlParser;
use Illuminate\Support\Facades\Cache;

class AuthorizationCodeExtractor
{
    use UrlParser;

    public function cacheCode($url)
    {
        if ($this->isCallbackURLContainsCodeParameter($url)) {
            $queryParameters = $this->parseUrl($url);

            Cache::put('instagram_code', $this->removeInstagramsSpecialCharacters($queryParameters['code']), now()->addMinutes(60));
            return true;
        }
    }

    public function isCallbackURLContainsCodeParameter(string $url): bool
    {
        $queryParameters = $this->parseUrl($url);
        return isset($queryParameters['code']) && !empty($queryParameters['code']);
    }

    private function removeInstagramsSpecialCharacters(string $url): string
    {
        return str_replace("#_", "", $url);
    }
}