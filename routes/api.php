<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('pessoa', 'PersonController@store')->name('person.store');

Route::group(['as' => 'account.', 'prefix' => 'account/'], function () {
    Route::post('credito', ['as' => 'credito', 'uses' => 'AccountController@credito']);
    Route::post('debito', ['as' => 'debito', 'uses' => 'AccountController@debito']);
    Route::post('transfer', ['as' => 'transfer', 'uses' => 'AccountController@transfer']);
    Route::get('balance/{cpf}', ['as' => 'balance', 'uses' => 'AccountController@balance']);
});
