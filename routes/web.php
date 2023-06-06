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
        Route::get('/user-medias', [InstagramController::class, 'getUserMedias'])->name('user-medias');
    });
});