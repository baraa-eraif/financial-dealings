<?php

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;
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

//Route::middleware('auth:api')->get('/api', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'seller', 'as' => 'seller.', 'middleware' => \Modules\Core\Http\Middleware\LanguageMiddleware::class], function () {

    Route::authApiRoutes();

    Route::group(['middleware' => 'auth:' . SELLER_GUARD], function () {

        Route::group(['prefix' => 'order'], function () {
            Route::post('/', 'OrderController@store');
            Route::get('/', 'OrderController@index');
        });

    });

});
