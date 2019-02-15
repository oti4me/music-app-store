<?php

namespace Tests\Mock;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Faker\Factory as Faker;
use App\helpers\AuthHelpers;
use App\Models\File;

class FileMock
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
  public function fileDetails()
  {
    Storage::fake('avatars');

    $file = UploadedFile::fake()->image('nickleback.mp3');

    return [
      "name" => $this->faker->name,
      "file" => $file,
    ];
  }

  /**
   * Invalid file detials
   *
   * @return {array} user
   */
  public function invalidFileDetails()
  {
    return [
      "name" => 'Test File',
      "file" => 'invalid file format',
    ];
  }

  /**
   * Delete file detials
   *
   * @return {array} user
   */
  public function deleteFileDetails()
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
  public function deleteFileNotFoundDetails()
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
  public static function getFilesFromDB()
  {
    return File::all();
  }

}