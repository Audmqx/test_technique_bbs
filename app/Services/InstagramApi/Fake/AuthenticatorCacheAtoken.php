<?php

namespace App\Services\InstagramApi\Fake;

use App\Services\InstagramApi\Authenticator;
use Illuminate\Support\Facades\Cache;

class AuthenticatorCacheAtoken extends Authenticator
{
    public function execute()
    {
        $this->cacheRequest();
    }

    private function cacheRequest()
    {
        Cache::put('access_token', "dummy", $seconds = 20);
    }
}