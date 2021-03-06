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

Route::get('/', 'FrontpageController')->name('frontpage');
Route::view('/welcome', 'welcome')->name('welcome');

Auth::routes(['reset' => false, 'confirm' => false]);
Route::get('login/{token}/{remember?}', [
    'as' => 'auth.email-authenticate',
    'uses' => 'Auth\LoginController@authenticateEmail'
]);

Route::get('/home', 'PenpalController@index')->name('home');
Route::get('/penpals', 'PenpalController@index')->name('penpals');
Route::get('/penpals.pdf', 'PenpalController@print')->name('penpals.pdf');
Route::view('users', 'users')->middleware(['auth', 'can:manage-penpals'])->name('users');
Route::get('stats', 'StatsController')->middleware(['auth', 'can:view-stats'])->name('stats');
Route::resource('address-request', 'AddressRequestController')->only(['index', 'create', 'store']);
Route::post('address-request/{addressRequest}/approve', 'AddressRequestController@approve')->name('address-request.approve');
Route::post('address-request/{addressRequest}/deny', 'AddressRequestController@deny')->name('address-request.deny');
Route::get('img/requests/{filename}', 'ImageRequestController@image')->middleware(['auth', 'can:approve-requests'])->name('request-image');
Route::get('img/small/requests/{filename}', 'ImageRequestController@smallImage')->middleware(['auth', 'can:approve-requests'])->name('request-image');
Route::get('img/tiny/requests/{filename}', 'ImageRequestController@tinyImage')->middleware(['auth', 'can:approve-requests'])->name('request-image');
// frontend access
Route::group(['prefix' => 'ajax', 'middleware' => 'auth'], function () {
    Route::resource('address', 'AddressController')->only(['index', 'update', 'show']);
    Route::resource('users', 'UserController')->only(['index', 'update'])->middleware('can:manage-penpals');
});
