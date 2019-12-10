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

Auth::routes(['reset' => false, 'confirm' => false]);
Route::get('login/{token}/{remember?}', [
    'as' => 'auth.email-authenticate',
    'uses' => 'Auth\LoginController@authenticateEmail'
]);


Route::get('/home', 'HomeController@index')->name('home');

// frontend access
Route::group(['prefix' => 'ajax', 'middleware' => 'auth'], function () {
    Route::get('address/request', 'AddressController@additionalAddresses')
        ->name('address.request');
//        ->middleware('throttle:1,1');
    Route::resource('address', 'AddressController')->only(['index', 'update', 'show']);
});
