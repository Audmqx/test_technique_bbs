<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

use App\Services\InstagramApi;


class ApiTest extends TestCase
{
    public $instagramApiService;
    private $callbackURL;

    public function setUp() :void
    {
      parent::setUp();
      $this->instagramApiService = new InstagramApi;
      $this->callbackURL = "https://audmqx.github.io/test_technique_bbs/auth?code=AQDa2gtcYapyeuofakR2M7jl5iC-gTy67lT3TP_FAdEAf-2n5dg8B-2-7bhXb4kfghygzl6z-RKp0GEv5gv6nAqyqbrBf";

    }

    public function test_that_callback_url_has_uri() :void
    {
      $this->instagramApiService->setRedirectUri(config('services.instagram.redirect_uri'));
      $this->assertTrue($this->instagramApiService->isCallbackURLContainsUri($this->callbackURL));
    }

    public function test_that_callback_url_has_code_parameter() :void
    {
      $this->assertTrue($this->instagramApiService->isCallbackURLContainsCodeParameter($this->callbackURL));
    }
}
