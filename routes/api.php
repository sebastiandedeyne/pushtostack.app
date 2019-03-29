<?php

use App\Http\Middleware\CurrentUserScope;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth', CurrentUserScope::class)->group(function () {
    Route::resource('links', 'LinksController', ['only' => ['index', 'store', 'destroy']]);
});

