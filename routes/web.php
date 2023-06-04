<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstagramController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('instagram')->group(function () {
    Route::get('/auth', [InstagramController::class, 'handleCallback']);

    Route::prefix('get')->group(function () {
        Route::get('/code', [InstagramController::class, 'redirectToCallbackURL']);
        Route::get('/token', [InstagramController::class, 'getToken']);
        Route::get('/medias-ids', [InstagramController::class, 'getMediaIDS']);
    });
});