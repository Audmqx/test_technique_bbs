<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

use App\Services\InstagramApi\InstagramAuthorizationUrlBuilder;
use App\Services\InstagramApi\InstagramAuthorizationCodeExtractor;
use App\Services\InstagramApi\Mock\InstagramAuthorizationRedirectorMock;


class ApiTest extends TestCase
{
    private $authorizationUrlBuilder;
    private $authorizationCodeExtractor;
    private $dummyCallBackUrl;

    public function setUp() :void
    {
      parent::setUp();
      $this->authorizationUrlBuilder = new InstagramAuthorizationUrlBuilder;
      $this->authorizationUrlBuilder->setRedirectUri(config('services.instagram.redirect_uri'));
      $this->authorizationCodeExtractor = new InstagramAuthorizationCodeExtractor($this->authorizationUrlBuilder->getRedirectUri());
      $this->dummyCallBackUrl =  InstagramAuthorizationRedirectorMock::redirectToInstagramAuthorisation();
    }

    public function test_that_callback_url_has_uri() :void
    {
      $this->assertTrue($this->authorizationCodeExtractor->isCallbackURLContainsUri($this->dummyCallBackUrl));
    }

    public function test_that_callback_url_has_code_parameter() :void
    {
      $this->assertTrue($this->authorizationCodeExtractor->isCallbackURLContainsCodeParameter($this->dummyCallBackUrl));
    }
}
