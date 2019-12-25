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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//\Illuminate\Support\Facades\Route::get('about', function () {
//    return view('about');
//});

Route::view('about','about');

Route::get('contact', function () {
    return view('contact');
});

Route::get('customers', 'CustomersController@list');

Route::post('customers', 'CustomersController@store');
