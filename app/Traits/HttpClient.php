<?php

namespace App\Traits;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

trait HttpClient
{
    private $client;

    public function post(string $url, array $data)
    {
        $client = new GuzzleClient();

        try {
            return $client->post($url, ['form_params' => $data]);
        } catch (ClientException $e) {
            if ($this->isResponseAnError($e->getResponse())) {
                return $e->getResponse();
            }
        }
    }

    public function get(string $url, array $data)
    {
        $client = new GuzzleClient();

        try {
            return $client->request('GET', $url, ['query' => $data]);
        } catch (ClientException $e) {
            if ($this->isResponseAnError($e->getResponse())) {
                return $e->getResponse();
            }
        }
    }

    private function isResponseAnError($response)
    {
        return $response->getStatusCode() == 400 ? true : false;
    }
}