<?php

use Illuminate\Http\Request;

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

Route::get('/', function (Request $request) {
    return "Welcome to the music app api endpoint";
});

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/signup', 'UsersController@userSignup');
        Route::post('/signin', 'UsersController@userSignin');
    });
    Route::group(['prefix' => 'files'], function () {
        Route::post('/', 'FilesController@uploadFile');
        Route::get('/download', 'FilesController@downloadFile');
        Route::post('/download', 'FilesController@downloadFile');
    });
});
