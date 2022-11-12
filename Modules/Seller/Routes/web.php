<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use \Illuminate\Support\Facades\Route;

//Route::prefix('api')->group(function() {
//    Route::get('/', 'APIController@index');
//});
Route::prefix('seller')->group(function () {
    Route::get('/{any}', 'SellerController@index');
    Route::get('/dashboard', 'SellerController@index');
    Route::get('/login', 'SellerController@index');
    Route::get('/auth/login', 'SellerController@index');
    Route::any('{any}/{any2}', 'SellerController@index');
});
