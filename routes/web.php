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

Route::view('about', 'about');

Route::view('home', 'home');

Route::get('contact', function () {
    return view('contact');
});

//Route::get('customers', 'CustomersController@index');
//Route::get('customers/create', 'CustomersController@create');
//Route::post('customers', 'CustomersController@store');
//Route::get('customers/{customer}', 'CustomersController@show');
//Route::get('/customers/{customer}/edit', 'CustomersController@edit');
//Route::patch('customers/{customer}', 'CustomersController@update');
//Route::delete('customers/{customer}', 'CustomersController@destroy');
Route::resource('customers', 'CustomersController');
Route::get('/customers/{customer}/delete', 'CustomersController@destroy');
Route::get('ajax-pagination', 'AjaxController@ajaxPagination')->name('ajax.pagination');
Route::get('send','mailController@send');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
