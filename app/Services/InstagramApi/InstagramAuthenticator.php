<?php

namespace App\Services\InstagramApi;

use App\Traits\httpClient;
use Illuminate\Support\Facades\Http;

class InstagramAuthenticator
{
    use httpClient;

    private $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function setUrl()
    {
        return "https://api.instagram.com/oauth/access_token";
    }

    public function setParameters(): array
    {
        return ['client_id' => config('services.instagram.app_id'),
                'client_secret' => config('services.instagram.app_secret'),
                'grant_type' => 'authorization_code',
                'redirect_uri' => config('services.instagram.redirect_uri'),
                'code' => $this->code,
                ];
    }

    public function getToken()
    {
        $response = $this->post($this->setUrl(), $this->setParameters());
        return json_decode($response->getBody(), true);
    }
}