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
use App\Services\InstagramApi\UserMedias;
use Illuminate\Support\Facades\Cache;


class InstagramController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function redirectToCallbackURL()
    {
        $authorizationUrlBuilder = new AuthorizationUrlBuilder;
        $authorizationUrlBuilder->setClientId(config('services.instagram.app_id'));
        $authorizationUrlBuilder->setRedirectUri(config('services.instagram.redirect_uri'));

        Redirector::redirectTo($authorizationUrlBuilder->getConstructedUrl());
    }

    public function handleCallback()
    {
        $codeExtractor = new AuthorizationCodeExtractor();

        if ($codeExtractor->cacheCode(url()->full())) {
            $this->getUserMedias();
        }
    }


    public function getUserMedias($response = [])
    {
        $instagramApiService = new ApiServiceStrategy();

        if (isset($response['error_type'])) {
            $this->handleError($response);
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
        return view('posts', ['posts' => $instagramApiService->execute()]);
    }

    public function showError()
    {
        if (Cache::has('error')) {
            return view('welcome', ['errorBag' => Cache::get('error')]);
        }
    }

    private function handleError(array $response)
    {
        Cache::set('error', $response);
        Redirector::redirectTo(route('show-error'));
    }
}
