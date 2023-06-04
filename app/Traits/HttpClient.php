<?php

namespace App\Traits;

use GuzzleHttp\Client as GuzzleClient;

trait HttpClient
{
    private $client;

    public function post(string $url, array $data)
    {
        $client = new GuzzleClient();
        $response = $client->post($url, ['form_params' => $data]);

        if ($this->isResponseAnError($response)) {
            $this->handleError($response);
        }

        return $response;
    }

    public function get(string $url, array $data)
    {
        $client = new GuzzleClient();
        $response = $client->request('GET', $url, [
            'query' => $data
        ]);

        if ($this->isResponseAnError($response)) {
            $this->handleError($response);
        }

        return $response;
    }

    public function isResponseAnError($response)
    {
        return $response->getStatusCode() == 400 ? true : false;
    }

    public function handleError($response)
    {
        $bodyMessage = json_decode($response->getBody(), true);
        
        return response()->json([
            'status' => 400,
            'error_type' => $bodyMessage['error_type'],
            'error_message' => $bodyMessage['error_message'],
        ]);
    }
}