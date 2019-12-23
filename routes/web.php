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

Route::get('/', function () {
    return view('welcome');
});

//\Illuminate\Support\Facades\Route::get('about', function () {
//    return view('about');
//});

\Illuminate\Support\Facades\Route::view('about','about');

\Illuminate\Support\Facades\Route::get('contact', function () {
    return view('contact');
});

\Illuminate\Support\Facades\Route::get('customers', function () {
    $customers = [
        'John Doe1',
        'John Doe2',
        'John Doe3'
    ];


    return view('internals.customers',
    ['customers' => $customers]
    );
});
