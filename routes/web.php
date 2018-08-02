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
    return view('home');
})->middleware('auth');

Route::middleware(['auth',])->group(function () {
    Route::get('user/edit/{id}','UserController@edit')->name('user.edit');
    Route::post('user/update/{id}','UserController@update')->name('user.update');

    Route::get('user/password/{id}','UserController@changePassword')->name('user.changePassword');
    Route::post('user/password/{id}','UserController@updatePassword')->name('user.updatePassword');
   //----wallet
    Route::get('/wallet','WalletController@index')->name('walllet.index');
    Route::get('/wallet/create','WalletController@create')->name('wallet.create');
    Route::post('/wallet/','WalletController@store')->name('wallet.store');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('user/activation/{activationCode}','Auth\RegisterController@activateUser')->name('user.active');

