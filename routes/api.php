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

Route::post('person', 'PersonController@store')->name('person.store');

Route::group(['as' => 'account.', 'prefix' => 'account/'], function () {
    Route::post('credit', ['as' => 'credit', 'uses' => 'AccountController@credit']);
    Route::post('debit', ['as' => 'debit', 'uses' => 'AccountController@debit']);
    Route::post('transfer', ['as' => 'transfer', 'uses' => 'AccountController@transfer']);
    Route::get('balance/{cpf}', ['as' => 'balance', 'uses' => 'AccountController@balance']);
    Route::get('statement/{cpf}', ['as' => 'statement', 'uses' => 'AccountController@statement']);
});
