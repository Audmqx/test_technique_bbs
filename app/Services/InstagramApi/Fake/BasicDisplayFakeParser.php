<?php

namespace App\Services\InstagramApi\Fake;

use GuzzleHttp\Psr7\Response;

class BasicDisplayFakeParser
{
    public function getMediasIDS()
    {
        return [
                "id" => 0000000000000,
                "username" => "username",
                "media" => ['data' => [0, 1, 2, 3, 4, 5]],
                "media_count" => 5,
                ];
    }
}