<?php

namespace Tests\Feature\App\Http\Controller;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mock\SongMock;
use Illuminate\Support\Facades\Artisan;
use App\Helpers\AuthHelpers;
use App\Helpers\UserHelper;
use App\Helpers\SongsHelper;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class SongsControllerTest extends TestCase
{

  protected function setUp()
  {
    parent::setUp();

    $songMock = new SongMock();

    $this->header = $songMock->mockUserToken();

    $this->songDetails = $songMock->songDetails();

    $this->deleteSongDetails = $songMock->deleteSongDetails();

    $this->invalidSongDetails = $songMock->invalidSongDetails();

    $this->deleteSongNotFoundDetails = $songMock->deleteSongNotFoundDetails();
  }

  /**
   * Test File Uplaod Success.
   *
   * @return void
   */
  public function testSongUploadSuccess()
  {
    $response = $this->post('/api/v1/songs', $this->songDetails, $this->header);

    $response->assertStatus(201);

    $response->assertJsonFragment([
      'message' => 'File uploaded',
    ]);
  }

  /**
   * Test File upload validation Error.
   *
   * @return void
   */
  public function testSongUploadValidationError()
  {
    $response = $this->post('/api/v1/songs', $this->invalidSongDetails, $this->header);

    $response->assertStatus(422);

    $response->assertJsonFragment([
      'file' => ['The file must be a file.'],
    ]);
  }

  public function testSongUploadFileTypeValidationError()
  {
    $songDetails = [
      'title' =>'Whatever you want',
      'genre' => 'Rock',
      'artist' => 'Guns and Roses',
      'file' => UploadedFile::fake()->image('music.jpg')
    ];

    $response = $this->post('/api/v1/songs', $songDetails, $this->header);

    $response->assertStatus(422);

    $response->assertJsonFragment([
      'message' => 'File must be an mp3 file',
    ]);
  }

  public function testSongUploadDuplicateError()
  {
    $song = Song::find(1);

    $user = User::find($song->user_id);
    $token = AuthHelpers::jwtEncode($user);

    $songDetails = [
      'title' => $song->title,
      'genre' => 'Rock',
      'artist' => 'Guns and Roses',
      'file' => UploadedFile::fake()->image('music.mp3')
    ];

    $response = $this->post('/api/v1/songs', $songDetails, [
      'Authorization' => $token
    ]);

    $response->assertStatus(409);

    $response->assertJsonFragment([
      'message' => 'You already have a song with this title',
    ]);
  }

  /**
   * Test File upload validation Error.
   *
   * @return void
   */
  public function testSongUploadAuthenticationError()
  {
    $header = [
      'Authorization' => 'thisisafaketoken'
    ];

    $response = $this->post('/api/v1/songs', $this->invalidSongDetails, $header);

    $response->assertStatus(401);

    $response->assertJsonFragment([
      'message' => 'Unauthenticated',
    ]);
  }

  /**
   * Test Fetch Files.
   *
   * @return void
   */
  public function testFetchSong()
  {
    $response = $this->get('/api/v1/songs', $this->header);

    $response->assertStatus(200);

    $response->assertJsonFragment([
      'message' => 'in coming songs list',
    ]);
  }

  /**
   * Test Fetch My Files.
   *
   * @return void
   */
  public function testFetchMySongs()
  {
    $song = SongsHelper::getSong();

    $user = UserHelper::getUserById($song->user_id);

    $token = AuthHelpers::jwtEncode($user);

    $header = [
      'Authorization' => $token
    ];

    $response = $this->get('/api/v1/songs/me', $header);

    $response->assertStatus(200);

    $response->assertJsonFragment([
      'message' => 'in coming songs list',
    ]);
  }

  /**
   * Test search songs.
   *
   * @return void
   */
  public function testSearchSong()
  {
    $searchTerm = 'blues';

    $response = $this->post('/api/v1/songs/search', [ 'searchTerm' => $searchTerm ], $this->header);

    $response->assertStatus(200);

    $response->assertJsonFragment([
      'message' => 'in coming songs list',
    ]);
  }


  /**
   * Test Delete File Seccess.
   *
   * @return void
   */
  public function testDownloadSongSuccess()
  {
    $song = SongMock::getSongsFromDB()[0];
    
    $response = $this->get('/api/v1/songs/download?url='. $song->url, $this->header);

    $response->assertStatus(200);
  }

  /**
   * Test Delete File Seccess.
   *
   * @return void
   */
  public function testDownloadSongFailure()
  {
    $song = "pathtononeexistingfile";

    $response = $this->get('/api/v1/songs/download?url=' . $song, $this->header);

    $response->assertStatus(404);

    $response->assertJsonFragment([
      'message' => 'This file is not found',
    ]);
  }

  /**
   * Test Delete File Seccess.
   *
   * @return void
   */
  public function testDeleteSongSuccess()
  {
    $song = SongsHelper::getSong();
    
    $user = UserHelper::getUserById($song->user_id);

    $token = AuthHelpers::jwtEncode($user);

    $header = [
      'Authorization' => $token
    ];

    $response = $this->delete('/api/v1/songs/' . $song->id, [], $header);

    $response->assertStatus(200);
  }

  /**
   * Test Delete File Not Found Error.
   *
   * @return void
   */
  public function testDeleteSongNotFound()
  {
    $response = $this->delete('/api/v1/songs/' . '200', [], $this->header);

    $response->assertStatus(404);

    $response->assertJsonFragment([
      'message' => 'File not found for this user',
    ]);
  }

  /**
   * Test Delete File Validation Error.
   *
   * @return void
   */
  public function testDeleteSongValidationError()
  {
    $response = $this->delete('/api/v1/songs/' . 'edfg', [], $this->header);

    $response->assertStatus(400);

    $response->assertJsonFragment([
      'message' => 'Invalid ID',
    ]);
  }
}
