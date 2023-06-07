<?php

namespace App\Helpers;

class Redirector
{
    public static function redirectTo(string $url): void
    {
        header("Location: ".$url);
        exit;
    }
}