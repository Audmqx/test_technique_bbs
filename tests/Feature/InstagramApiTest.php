<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Support\Facades\Http;

use App\Services\InstagramApi;

//Récupérer les derniers posts (donc quelques posts pas tous ceux de la page) et les afficher sur une page.

class InstagramApiTest extends TestCase
{
   
    public function test_the_constructed_url_return_a_succesfull_response(): void
    {
        $instagramApiService =  new InstagramApi;

        $instagramApiService->setClientId(config('services.instagram.app_id'));
        $instagramApiService->setAppSecret(config('services.instagram.app_secret'));
        $instagramApiService->setRedirectUri(config('services.instagram.redirect_uri'));

        $urlCallBackDummy = "https://audmqx.github.io/test_technique_bbs/auth?code=authCode";

        Http::fake([
            $instagramApiService->getConstructedUrl() => Http::response(['callbackUrl' => $urlCallBackDummy], 200),
        ]);

      
        $this->assertEquals("authCode", $instagramApiService->getCode($urlCallBackDummy));

        //should return : https://audmqx.github.io/test_technique_bbs/auth?code=AQDa2gtcYapyeuofakR2M7jl5iC-gTy67lT3TP_FAdEAf-2n5dg8B-2-7bhXb4kfghygzl6z-RKp0GEv5gv6nAqyqbrBfcklMh1GsV8O9MZVpgeiqfsgCAgDadsg3YXQ_6DfM8fuKnHkum6jDS8Ru_dPTFh-AWgRNGB6zqun7qAHT4OHNlPv3NQ-LGr4QuMZLnHZsrPzmFY4Pkh9ufNYa8aBztm0WE4Cec_ky_dRrXeUoA#_
    }
}
