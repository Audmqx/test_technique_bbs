<?php

namespace App\Traits;

trait UrlParser
{
    public function parseUrl(string $url): array
    {
        $parsedUrl = parse_url($url);
        parse_str($parsedUrl['query'], $queryParameters);

        return $queryParameters;
    }
}