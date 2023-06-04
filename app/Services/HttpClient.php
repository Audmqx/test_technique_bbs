<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;

class httpClient
{
    private $client;

    public function __construct()
    {
        $this->client = new GuzzleClient();
    }

    public function post(string $url, array $data)
    {
        return $this->client->post($url, ['form_params' => $data]);
    }
}