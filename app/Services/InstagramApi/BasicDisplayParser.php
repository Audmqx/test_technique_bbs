<?php

namespace App\Services\InstagramApi;

use App\Traits\HttpClient;

class BasicDisplayParser
{
    use HttpClient;

    private $userId;
    private $accesToken;
    private $baseUrl = "https://graph.instagram.com/";

    public $posts = [];

    public function __construct(int $userId, string $accesToken)
    {
        $this->userId = $userId;
        $this->accesToken = $accesToken;
    }
    

    public function getParameters()
    {
        return ['fields' => 'id,username,media,media_count',
                'access_token' =>  $this->accesToken];
    }

    public function getMediasIDS()
    {
        $getParemeters = ['fields' => 'id,username,media,media_count',
        'access_token' =>  $this->accesToken];

        $response = $this->get($this->baseUrl.$this->userId, $getParemeters);

        return json_decode($response->getBody(), true);

    }

    public function isMediaExists(array $response)
    {
        if (isset($response['media_count']) && $response['media_count'] > 0) {
            return true;
        }

        return false;
    }
}