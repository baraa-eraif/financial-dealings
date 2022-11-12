<?php

use Illuminate\Http\Request;

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
//
//Route::middleware('auth:api')->get('/core', function (Request $request) {
//    return $request->user();
//});
////\Illuminate\Support\Facades\Route::group(['prefix' => 'image'], function () {
////  \Illuminate\Support\Facades\Route::post('/upload', 'ImageController@upload');
////});
Route::prefix('image')->group(function () {
  Route::get('/{size}/{id}', ['as' => 'image', 'uses' => 'ImageController@getPublicImage']);
  Route::get('/{id}', ['as' => 'image_get', 'uses' => 'ImageController@getDefaultImage']);
  Route::get('/limit/{size}/{id}', ['as' => 'image', 'uses' => 'ImageController@getImageResize']);
  Route::post('/upload', ['as' => 'upload', 'uses' => 'ImageController@upload']);
});
