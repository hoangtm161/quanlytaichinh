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
    return redirect()->route('wallet.index');
})->middleware('auth');

Route::middleware(['auth',])->group(function () {
    Route::get('user/edit/{id}','UserController@edit')->name('user.edit');
    Route::post('user/update/{id}','UserController@update')->name('user.update');

    Route::get('user/password/{id}','UserController@changePassword')->name('user.changePassword');
    Route::post('user/password/{id}','UserController@updatePassword')->name('user.updatePassword');
   //----wallet
    Route::get('/wallet','WalletController@index')->name('wallet.index');
    Route::get('/wallet/create','WalletController@create')->name('wallet.create');
    Route::post('/wallet','WalletController@store')->name('wallet.store');
    Route::get('/wallet/edit/{id}','WalletController@edit')->name('wallet.edit');
    Route::post('/wallet/{id}','WalletController@update')->name('wallet.update');

    Route::get('/wallet/delete/{id}','WalletController@delete')->name('wallet.delete');
    Route::get('/transaction/history/{id}','WalletController@showHistory')->name('wallet.history');

        //----transfer
    Route::get('/transfer','TransferController@index')->name('transfer.index');
    Route::get('/wallet/transfer/{id}','TransferController@create')->name('transfer.create');
    Route::post('/transfer/{id}','TransferController@store')->name('transfer.store');
    //-----category
    Route::get('/category','CategoryController@index')->name('category.index');
    Route::get('/category/create','CategoryController@create')->name('category.create');
    Route::post('/category/','CategoryController@store')->name('category.store');
    Route::get('category/edit/{id}','CategoryController@edit')->name('category.edit');
    Route::post('/category/update/{id}','CategoryController@update')->name('category.update');
    Route::get('/category/delete/{id}','CategoryController@delete')->name('category.delete');
    //-----transaction
    Route::get('/transaction','TransactionController@index')->name('transaction.index');
    Route::get('/transaction/create','TransactionController@create')->name('transaction.create');
    Route::post('/transaction/','TransactionController@store')->name('transaction.store');
    Route::get('/transaction/edit/{id}','TransactionController@edit')->name('transaction.edit');
    Route::post('/transaction/update/{id}','TransactionController@update')->name('transaction.update');
    Route::get('/transaction/delete/{id}','TransactionController@delete')->name('transaction.delete');
    Route::get('transaction/category/{id}','TransactionController@showTransactionByCategory')->name('transaction.category');
    Route::post('transaction/time','TransactionController@showTransactionByTime')->name('transaction.time');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('user/activation/{activationCode}','Auth\RegisterController@activateUser')->name('user.active');

