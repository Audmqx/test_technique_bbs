<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Services\InstagramApi\AuthorizationCodeExtractor;
use App\Services\InstagramApi\AuthorizationUrlBuilder;
use App\Helpers\Redirector;
use App\Services\httpClient;
use App\Services\InstagramApi\InstagramAuthenticator;

use App\Services\InstagramApi\BasicDisplayParser;

class InstagramController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function redirectToCallbackURL()
    {
        $authorizationUrlBuilder = new AuthorizationUrlBuilder;
        $authorizationRedirector = new Redirector;
     
        $authorizationUrlBuilder->setClientId(config('services.instagram.app_id'));
        $authorizationUrlBuilder->setRedirectUri(config('services.instagram.redirect_uri'));

        $getConstructedUrl = $authorizationUrlBuilder->getConstructedUrl();

        $authorizationRedirector->redirectTo($getConstructedUrl);
    }

    public function handleCallback()
    {
        $codeExtractor = new AuthorizationCodeExtractor();
        if ($code = $codeExtractor->getCode(url()->full())) {
            session(['instagram_code' => $code]);
            echo 'code setted';
        }
    }

    public function getToken()
    {
        if (!session('instagram_code')){
            return 'error with code';
        }

        $tokenAccessor = new InstagramAuthenticator(session('instagram_code'));

        return $tokenAccessor->getToken();
    }

    public function getMediaIDS()
    {
        $token = $this->getToken();

        if (!isset($token['access_token'])) {
            return 'error with token';
        }

        $basicDisplayParser = new BasicDisplayParser($token['user_id'], $token['access_token']);
        
        return $basicDisplayParser->getMediasIDS();
    }
}
