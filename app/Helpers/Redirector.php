<?php

namespace App\Helpers;

class Redirector
{
    public function redirectTo(string $url): void
    {
        header("Location: ".$url);
        exit;
    }
}