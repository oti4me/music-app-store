<?php

namespace Tests\Mock;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Faker\Factory as Faker;
use App\helpers\AuthHelpers;
use App\Models\Song;

class SongMock
{
  public function __construct()
  {
    $this->faker = Faker::create();
  }

  public function mockUserToken() {
    $user = factory(\App\Models\User::class)->create();

    $token = AuthHelpers::jwtEncode($user);

    return ['Authorization' => $token];
  }

  /**
   * File detials
   *
   * @return {array} user
   */
  public function songDetails()
  {
    Storage::fake('avatars');

    $file = UploadedFile::fake()->image('music.mp3');

    return [
      "title" => $this->faker->name,
      "genre" => 'Rap',
      "artist" => $this->faker->firstName,
      "file" => $file,
    ];
  }

  /**
   * Invalid file detials
   *
   * @return {array} user
   */
  public function invalidSongDetails()
  {
    return [
      "title" => 'Test File',
      "file" => 'invalid file format',
    ];
  }

  /**
   * Delete file detials
   *
   * @return {array} user
   */
  public function deleteSongDetails()
  {
    return [
      'url' => 'linktofile',
    ];
  }

  /**
   * Delete file not found detials
   *
   * @return {array} user
   */
  public function deleteSongNotFoundDetails()
  {
    return [
      'url' => 'linktofile',
    ];
  }

  /**
   * Delete file not found detials
   *
   * @return {array} user
   */
  public static function getSongsFromDB()
  {
    return Song::all();
  }

}