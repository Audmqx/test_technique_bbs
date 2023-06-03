<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Support\Facades\Http;

use App\Services\InstagramApi\InstagramApi;
use App\Services\InstagramApi\InstagramAuthorizationCodeExtractor;
use App\Services\InstagramApi\InstagramAuthorizationUrlBuilder;
use App\Services\InstagramApi\Mock\InstagramAuthorizationRedirectorMock;

//Récupérer les derniers posts (donc quelques posts pas tous ceux de la page) et les afficher sur une page.

class InstagramApiTest extends TestCase
{
   
    public function test_that_instagram_api_should_return_a_temp_code(): void
    {
        $authorizationUrlBuilder = new InstagramAuthorizationUrlBuilder;
        $authorizationRedirectorMock = new InstagramAuthorizationRedirectorMock;
     
        $authorizationUrlBuilder->setClientId(config('services.instagram.app_id'));
        $authorizationUrlBuilder->setRedirectUri(config('services.instagram.redirect_uri'));

        $getConstructedUrl = $authorizationUrlBuilder->getConstructedUrl();

        $callBackUrlStub = $authorizationRedirectorMock->redirectToInstagramAuthorisation($getConstructedUrl);

        $codeExtractor = new InstagramAuthorizationCodeExtractor($authorizationUrlBuilder->getRedirectUri());

        $this->assertEquals("authCode", $codeExtractor->getCode($callBackUrlStub));
    }
}
