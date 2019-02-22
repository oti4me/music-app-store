<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Tests\Mock\SongMock;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Song::class, function (Faker $faker) {
    $songMock = new SongMock();
    $song = $songMock->songDetails();

    $usersId = User::all()->pluck('id')->toArray();

    return [
        'title'      => $song['title'],
        'url'       => $song['file'],
        'genre'       => $song[ 'genre'],
        'artist'       => $song[ 'artist'],
        'user_id'   => array_rand($usersId),
    ];
});
