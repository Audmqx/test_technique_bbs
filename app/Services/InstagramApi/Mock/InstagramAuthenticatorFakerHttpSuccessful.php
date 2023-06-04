<?php

namespace App\Services\InstagramApi\Mock;

use GuzzleHttp\Psr7\Response;

class InstagramAuthenticatorFakerHttpSuccessful
{
    public function post()
    {
        $response = [
            'status' => 200,
            'body' => [
                        'access_token' => '0000000000000',
                        "user_id" => 0000000000000000],
        ];

        return new Response(
            $response['status'],
            [],
            json_encode($response['body'])
        );
    }
}