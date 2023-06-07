<?php

namespace App\Services\InstagramApi;

use App\Contracts\InstagramApiStrategyInterface;
use App\Traits\HttpClient;
use Illuminate\Support\Facades\Cache;

class UserMedias implements InstagramApiStrategyInterface
{
    use HttpClient;

    const MAXIMUM_POSTS_TO_FETCH = 5;
    private $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function execute()
    {
        $response = $this->get($this->setUrl(), $this->setParameters());
        return json_decode($response->getBody(), true);
    }

    private function setUrl(): string
    {
        return "https://graph.instagram.com/me/media/";
    }

    private function setParameters(): array
    {
        return [
                'fields' => 'id,caption,media_type,media_url,username,timestamp,thumbnail_url,media_count',
                'access_token' => $this->accessToken,
                'limit' => self::MAXIMUM_POSTS_TO_FETCH,
                ];
    }
}