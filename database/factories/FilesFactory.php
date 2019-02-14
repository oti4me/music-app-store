<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Tests\Mock\FileMock;
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

$factory->define(App\Models\File::class, function (Faker $faker) {
    $fileMock = new FileMock();
    $file = $fileMock->fileDetails();

    $usersId = User::all()->pluck('id')->toArray();

    return [
        'name'      => $file['name'],
        'url'       => $file['file'],
        'user_id'   => array_rand($usersId),
    ];
});
