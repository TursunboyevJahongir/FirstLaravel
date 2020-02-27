<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/login', 'API\LoginController@index');

// Route::get('/users', 'API\UserController@index');
// Route::get('/users/{id}', 'API\UserController@show');
// Route::post('/users', 'API\UserController@store');
Route::put('/user/{id}', 'API\UserController@update');
Route::resource('/user', 'API\UserController');

// Route::get('/addresses', 'API\AddressController@index');
// Route::get('/address/{id}', 'API\AddressController@show');
Route::put('/address/{id}', 'API\AddressController@update');
Route::resource('/address', 'API\AddressController');

Route::put('/shop/{id}', 'API\ShopController@update');
Route::resource('/shop', 'API\ShopController');

Route::put('/product/{id}', 'API\ProductController@update');
Route::resource('/product', 'API\ProductController');

Route::put('/favourite/{id}', 'API\FavouriteController@update');
Route::resource('/favourite', 'API\FavouriteController');

Route::put('/follower/{id}', 'Api\FollowerController@update');
Route::resource('/follower', 'Api\FollowerController');

Route::put('/category/{id}', 'API\CategoryController@update');
Route::resource('/category', 'API\CategoryController');

Route::resource('/deliver', 'API\DeliverController');

Route::put('/district/{id}', 'API\DistrictController@update');
Route::resource('/district', 'API\DistrictController');

Route::put('/advertise/{id}', 'API\AdvertiseController@update');
Route::resource('/advertise', 'API\AdvertiseController');

Route::put('/manufacturer/{id}', 'API\ManufacturerController@update');
Route::resource('/manufacturer', 'API\ManufacturerController');

Route::put('/news/{id}', 'API\NewsController@update');
Route::resource('/news', 'API\NewsController');

Route::get('/search/{q}', 'API\SearchController@search');

Route::get('/searchShops/{q}', 'API\SearchController@searchShops');

Route::get('/searchProducts/{q}', 'API\SearchController@searchProducts');

Route::post('upload', 'FileController@fileSave');
