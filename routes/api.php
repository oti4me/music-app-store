<?php

use Illuminate\Http\Request;
use GuzzleHttp\Middleware;

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
    return "Welcome to the music app api endpoint visit /doc for api documentation";
});

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/signup', 'UsersController@userSignup');
        Route::post('/signin', 'UsersController@userSignin');
    });
    Route::group(['prefix' => 'songs', 'middleware' => 'token'], function () {
        Route::post('/', 'SongsController@uploadSong');
        Route::get('/', 'SongsController@getSongs');
        Route::get('/me', 'SongsController@getMySongs');
        Route::get('/download', 'SongsController@downloadSong');
        Route::delete('/{id}', 'SongsController@deleteSong');
        Route::post('/search', 'SongsController@searchSongs');

        Route::get('/favourites', 'FavouritesController@getFavourites');
        Route::post('/{id}/favourite', 'FavouritesController@addFavourite');
        Route::delete('/{id}/favourite', 'FavouritesController@removeFavourite');

        Route::post('/playlists', 'PlaylistController@createplaylist');
        Route::post('/{id}/playlists/{playlistId}', 'PlaylistController@addSong');
    });
});

Route::fallback(function(){
    return response()->json(['message' => 'Resource not Found!!'], 404);
});
