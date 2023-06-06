<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Services\InstagramApi\AuthorizationCodeExtractor;
use App\Services\InstagramApi\AuthorizationUrlBuilder;
use App\Helpers\Redirector;
use App\Services\InstagramApi\ApiServiceStrategy;
use App\Services\InstagramApi\Authenticator;

use App\Services\InstagramApi\BasicDisplayParser;
use App\Services\InstagramApi\InstagramApiService as InstagramApiInstagramApiService;
use App\Services\InstagramApi\UserMedias;
use Illuminate\Support\Facades\Cache;


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

        if ($codeExtractor->cacheCode(url()->full())) {
            $this->getUserMedias();
        }
    }


    public function getUserMedias($response = false)
    {
        $instagramApiService = new ApiServiceStrategy();

        if (isset($response['error_type'])) {
            dd($response);
        }

        if (!Cache::has('instagram_code')) {
            $this->redirectToCallbackURL();
        }
        
        if (!Cache::has('access_token')) {
            $instagramApiService->setStrategy(new Authenticator(Cache::get('instagram_code')));
            $response = $instagramApiService->execute();

            $this->getUserMedias($response);
        }

        $instagramApiService->setStrategy(new UserMedias(Cache::get('access_token')));
        return $instagramApiService->execute();
    }
}
