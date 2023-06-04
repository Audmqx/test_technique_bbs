<?php

namespace Tests\Feature;


use Tests\TestCase;

use App\Services\InstagramApi\AuthorizationCodeExtractor;
use App\Services\InstagramApi\AuthorizationUrlBuilder;
use App\Services\InstagramApi\Mock\AuthorizationRedirectorMock;

use App\Services\InstagramApi\InstagramAuthenticator;
use App\Services\InstagramApi\Fake\AuthenticatorFakerHttpSuccessful;


//Récupérer les derniers posts (donc quelques posts pas tous ceux de la page) et les afficher sur une page.

class InstagramApiTest extends TestCase
{
   
    public function test_that_instagram_api_should_return_a_temp_code(): void
    {
        $authorizationUrlBuilder = new AuthorizationUrlBuilder;
        $authorizationRedirectorMock = new AuthorizationRedirectorMock;
     
        $authorizationUrlBuilder->setClientId(config('services.instagram.app_id'));
        $authorizationUrlBuilder->setRedirectUri(config('services.instagram.redirect_uri'));

        $getConstructedUrl = $authorizationUrlBuilder->getConstructedUrl();

        $callBackUrlStub = $authorizationRedirectorMock->redirectTo($getConstructedUrl);

        $codeExtractor = new AuthorizationCodeExtractor();

        $this->assertEquals("authCode", $codeExtractor->getCode($callBackUrlStub));
    }

    public function test_that_instagram_should_grant_access_token_in_exchange_of_temp_code(): void
    {
        $httpClient = new AuthenticatorFakerHttpSuccessful();
        $tokenAccessor = new InstagramAuthenticator;
     
        $response = $httpClient->post();
   
        $this->assertArrayHasKey('access_token', $tokenAccessor->exchangeAuthorizationCodeToToken($response));
    }
}
