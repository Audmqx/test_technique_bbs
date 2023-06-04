<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Services\InstagramApi\AuthorizationCodeExtractor;
use App\Services\InstagramApi\AuthorizationUrlBuilder;
use App\Helpers\Redirector;

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
        }
    }
}
