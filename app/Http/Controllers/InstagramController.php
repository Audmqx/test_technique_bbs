<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Services\InstagramApi\InstagramAuthorizationCodeExtractor;
use App\Services\InstagramApi\InstagramAuthorizationUrlBuilder;
use App\Services\InstagramApi\InstagramAuthorizationRedirector;

class InstagramController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function redirectToCallbackURL()
    {
        $authorizationUrlBuilder = new InstagramAuthorizationUrlBuilder;
        $authorizationRedirector = new InstagramAuthorizationRedirector;
     
        $authorizationUrlBuilder->setClientId(config('services.instagram.app_id'));
        $authorizationUrlBuilder->setRedirectUri(config('services.instagram.redirect_uri'));

        $getConstructedUrl = $authorizationUrlBuilder->getConstructedUrl();

        $authorizationRedirector->redirectToInstagramAuthorisation($getConstructedUrl);
    }

    public function handleCallback()
    {
        $codeExtractor = new InstagramAuthorizationCodeExtractor();
        if ($code = $codeExtractor->getCode(url()->full())) {
            session(['instagram_code' => $code]);
        }
    }
}
