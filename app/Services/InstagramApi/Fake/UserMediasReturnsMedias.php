<?php

namespace App\Services\InstagramApi\Fake;

use GuzzleHttp\Psr7\Response;

class UserMediasReturnsMedias
{
    public function execute()
    {
        return [
                    "data" => [
                        ["id" => "17895695668004550", "caption" => ""],
                        ["id" => "17899305451014820", "caption" => ""],
                        ["id" => "17896450804038745", "caption" => ""],
                        ["id" => "17881042411086627", "caption" => ""]
                    ],
                    "paging" => [
                        "cursors" => [
                            "after" => "MTAxN...",
                            "before" => "NDMyN..."
                        ],
                        "next" => "https://graph.faceb..."
                    ]
                ];
    }
}