<?php

namespace Tests\Feature;


use Tests\TestCase;

use App\Services\InstagramApi\AuthorizationCodeExtractor;
use App\Services\InstagramApi\AuthorizationUrlBuilder;
use App\Services\InstagramApi\Mock\AuthorizationRedirectorMock;
use Illuminate\Support\Facades\Cache;


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

        $this->assertTrue($codeExtractor->cacheCode($callBackUrlStub));
        $this->assertTrue(Cache::has('instagram_code'));
          
        Cache::forget('instagram_code');
    }
}
