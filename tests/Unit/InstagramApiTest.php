<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Services\InstagramApi\AuthorizationUrlBuilder;
use App\Services\InstagramApi\AuthorizationCodeExtractor;

use App\Services\InstagramApi\Mock\AuthorizationRedirectorMock;

use App\Services\InstagramApi\Fake\UserMediasReturnsMedias;

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

  
    public function test_that_instagram_is_returning_user_medias(): void
    {
        $basicDisplayParser = new UserMediasReturnsMedias();
        $this->assertArrayHasKey('data', $basicDisplayParser->execute());
    }
}
