<?php

namespace Tests\Feature\App\Http\Controller;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mock\SongMock;
use Illuminate\Support\Facades\Artisan;
use App\Models\Playlist;
use App\Helpers\AuthHelpers;


class PlaylistControllerTest extends TestCase
{

  protected function setUp()
  {
    parent::setUp();

    $songMock = new SongMock();

    $this->header = $songMock->mockUserToken();

    $this->songDetails = $songMock->songDetails();
  }

  /**
   * Test File Uplaod Success.
   *
   * @return void
   */
  public function testCreatePlaylistSuccess()
  {
    $response = $this->post('/api/v1/songs/playlists', [
      'name' => 'Test Playlist',
    ], $this->header);

    $response->assertStatus(201);

    $response->assertJsonFragment([
      'message' => 'Playlist created',
    ]);
  }

  /**
   * Test File Uplaod Success.
   *
   * @return void
   */
  public function testCreatePlaylistValidationError()
  {
    $response = $this->post('/api/v1/songs/playlists', [
      'name' => '',
    ], $this->header);

    $response->assertStatus(422);

    $response->assertJsonFragment([
      'name' => ['The name field is required.'],
    ]);
  }

  /**
   * Test File Uplaod Success.
   *
   * @return void
   */
  public function testCreatePlaylistDuplicateError()
  {
    $playlist = Playlist::find(1);

    $token = AuthHelpers::jwtEncode($playlist->user);

    $header = [
      'Authorization' => $token
    ];
    
    $response = $this->post('/api/v1/songs/playlists', [
      'name' => 'Test Playlist',
    ], $header);

    $response->assertStatus(409);

    $response->assertJsonFragment([
      'message' => 'You have already created a playlist with this title',
    ]);
  }

  /**
   * Test File Uplaod Success.
   *
   * @return void
   */
  // public function testAddSongsToPlaylistSuccess()
  // {
  //   $playlist = Playlist::find(1);

  //   $token = AuthHelpers::jwtEncode($playlist->user);

  //   $header = [
  //     'Authorization' => $token
  //   ];

  //   $response = $this->post('/api/v1/songs/1/playlists/1', [
  //     'name' => 'Test Playlist',
  //   ], $header);

  //   dd( $response->json());

  //   $response->assertStatus(201);

  //   $response->assertJsonFragment([
  //     'message' => 'Song added to playlist',
  //   ]);
  // }

}
