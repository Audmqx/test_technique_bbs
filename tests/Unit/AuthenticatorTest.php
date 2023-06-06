<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

use App\Services\InstagramApi\Fake\AuthenticatorReturnsAnError;
use App\Services\InstagramApi\Fake\AuthenticatorCacheAtoken;

class AuthenticatorTest extends TestCase
{
    public function test_that_authenticator_should_cache_token_in_exchange_of_temp_code(): void
    {
        $fakeAuthenticator = new AuthenticatorCacheAtoken("dummyCode");
        $fakeAuthenticator->execute();

        $this->assertTrue(Cache::has('access_token'));
        Cache::forget('access_token');
    }

    public function test_that_authenticator_respond_with_an_error()
    {
        $tokenAccessor = new AuthenticatorReturnsAnError("dummyCode");
        
        $this->assertArrayHasKey('error_type', $tokenAccessor->execute());
        $this->assertFalse(Cache::has('access_token'));
    }
}
