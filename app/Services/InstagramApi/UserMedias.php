<?php

namespace App\Services\InstagramApi;

use App\Contracts\InstagramApiStrategyInterface;
use App\Traits\HttpClient;
use Illuminate\Support\Facades\Cache;

class UserMedias implements InstagramApiStrategyInterface
{
    use HttpClient;

    private $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function setUrl(): string
    {
        return "https://graph.instagram.com/";
    }

    public function setParameters(): array
    {
        return [
                'fields' => 'id,caption,media_type,media_url,username,timestamp,thumbnail_url,media_count',
                'access_token' => $this->accessToken
                ];
    }

    public function execute()
    {
        $response = $this->get($this->setUrl().'/me/media', $this->setParameters());
        return json_decode($response->getBody(), true);
    }
}