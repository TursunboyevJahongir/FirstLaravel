<?php

use App\Models\User;
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

Route::middleware('auth:api')->group(function () {
    Route::get('/ax', function (Request $request) {
       echo "axaax";
    });
});

//Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', 'API\UserController@login');
    Route::post('/register', 'API\UserController@register');
    Route::get('/logout', 'API\UserController@logout')->middleware('auth:api');
    //});
    
    Route::get('/login', 'API\LoginController@index');
    
    // Route::get('/user', 'API\UserController@index')->middleware('auth:api');
    Route::group(['middleware' => 'auth:api'],function (){
        Route::get('/user', 'API\UserController@index');
        Route::get('/users/{id}', 'API\UserController@show');
    });
    Route::post('/user', 'API\UserController@store');
    Route::put('/user/{id}', 'API\UserController@update');
    Route::delete('/user/{id}', 'API\UserController@destroy');

// Route::get('/addresses', 'API\AddressController@index');
// Route::get('/address/{id}', 'API\AddressController@show');
Route::resource('/address', 'API\AddressController');
Route::put('/address/{id}', 'API\AddressController@update');
Route::delete('/address/{id}', 'API\AddressController@destroy');

Route::put('/shop/{id}', 'API\ShopController@update');
Route::delete('/shop/{id}', 'API\ShopController@destroy');
Route::resource('/shop', 'API\ShopController');

Route::put('/product/{id}', 'API\ProductController@update');
Route::post('/product/main_image/{id}', 'API\ProductController@SetGlobalImage');
Route::delete('/image_del/{id}', 'API\ImageController@destroy');
Route::delete('/product/{id}', 'API\ProductController@destroy');
Route::resource('/product', 'API\ProductController');

Route::put('/favourite/{id}', 'API\FavouriteController@update');
Route::delete('/favourite/{id}', 'API\FavouriteController@destroy');
Route::resource('/favourite', 'API\FavouriteController');

Route::put('/follower/{id}', 'Api\FollowerController@update');
Route::delete('/follower/{id}', 'API\FollowerController@destroy');
Route::resource('/follower', 'Api\FollowerController');

Route::put('/category/{id}', 'API\CategoryController@update');
Route::delete('/category/{id}', 'API\CategoryController@destroy');
Route::resource('/category', 'API\CategoryController');

Route::resource('/deliver', 'API\DeliverController');

Route::put('/district/{id}', 'API\DistrictController@update');
Route::delete('/district/{id}', 'API\DistrictController@destroy');
Route::resource('/district', 'API\DistrictController');

Route::put('/region/{id}', 'API\RegionController@update');
Route::delete('/region/{id}', 'API\RegionController@destroy');
Route::resource('/region', 'API\RegionController');

Route::put('/advertise/{id}', 'API\AdvertiseController@update');
Route::delete('/advertise/{id}', 'API\AdvertiseController@destroy');
Route::resource('/advertise', 'API\AdvertiseController');

Route::put('/manufacturer/{id}', 'API\ManufacturerController@update');
Route::delete('/manufacturer/{id}', 'API\ManufacturerController@destroy');
Route::resource('/manufacturer', 'API\ManufacturerController');

Route::put('/news/{id}', 'API\NewsController@update');
Route::delete('/news/{id}', 'API\NewsController@destroy');
Route::resource('/news', 'API\NewsController');

Route::delete('/image/{id}', 'API\ImageController@destroy');

Route::get('/search/{q}', 'API\SearchController@search');

Route::get('/searchShops/{q}', 'API\SearchController@searchShops');

Route::get('/searchProducts/{q}', 'API\SearchController@searchProducts');

Route::post('upload', 'FileController@fileSave');
