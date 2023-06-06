<?php

namespace App\Services\InstagramApi;

use App\Contracts\InstagramApiStrategyInterface;
use App\Traits\HttpClient;
use Illuminate\Support\Facades\Cache;

class Authenticator implements InstagramApiStrategyInterface
{
    use HttpClient;

    private $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function execute()
    {
        $response = $this->post($this->setUrl(), $this->setParameters());
        $response = json_decode($response->getBody(), true);

        if (isset($response['error_type'])) {
            return $response;
        }

        $this->cacheRequest($response);
    }

    private function setUrl(): string
    {
        return "https://api.instagram.com/oauth/access_token";
    }

    private function setParameters(): array
    {
        return ['client_id' => config('services.instagram.app_id'),
                'client_secret' => config('services.instagram.app_secret'),
                'grant_type' => 'authorization_code',
                'redirect_uri' => config('services.instagram.redirect_uri'),
                'code' => $this->code,
                ];
    }

    private function cacheRequest(array $response): void
    {
        Cache::put('access_token', $response['access_token'], now()->addMinutes(60));
    }
}