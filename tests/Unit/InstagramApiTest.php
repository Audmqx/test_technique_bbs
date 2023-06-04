<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

use App\Services\InstagramApi\AuthorizationUrlBuilder;
use App\Services\InstagramApi\AuthorizationCodeExtractor;
use App\Services\InstagramApi\Mock\AuthorizationRedirectorMock;
use App\Services\InstagramApi\Fake\InstagramAuthenticatorReturnsAnError;
use App\Services\InstagramApi\Fake\InstagramAuthenticatorReturnsToken;
use App\Services\InstagramApi\Fake\BasicDisplayFakeParser;

class InstagramApiTest extends TestCase
{
    private $authorizationUrlBuilder;
    private $authorizationCodeExtractor;
    private $dummyCallBackUrl;

    public function setUp() :void
    {
      parent::setUp();
      $this->authorizationUrlBuilder = new AuthorizationUrlBuilder;
      $this->authorizationUrlBuilder->setRedirectUri(config('services.instagram.redirect_uri'));
      $this->authorizationCodeExtractor = new AuthorizationCodeExtractor();
      $this->dummyCallBackUrl =  AuthorizationRedirectorMock::redirectTo();
    }

    public function test_that_callback_url_has_code_parameter() :void
    {
      $this->assertTrue($this->authorizationCodeExtractor->isCallbackURLContainsCodeParameter($this->dummyCallBackUrl));
    }

    public function test_that_instagram_should_grant_access_token_in_exchange_of_temp_code(): void
    {
        $tokenAccessor = new InstagramAuthenticatorReturnsToken("dummyCode");
        $this->assertArrayHasKey('access_token', $tokenAccessor->getToken());
    }

    public function test_that_instagram_respond_with_an_error()
    {
        $tokenAccessor = new InstagramAuthenticatorReturnsAnError("dummyCode");
        $this->assertArrayHasKey('error_type', $tokenAccessor->getToken());
    }

    public function test_that_instagram_should_return_medias_id()
    {
        $basicDisplayParser = new BasicDisplayFakeParser();
        $response = $basicDisplayParser->getMediasIDS();
        $this->assertArrayHasKey('media', $response);
    }
}
