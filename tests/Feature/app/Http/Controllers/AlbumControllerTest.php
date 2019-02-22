<?php

namespace Tests\Feature\App\Http\Controller;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mock\SongMock;
use Illuminate\Support\Facades\Artisan;
use App\Helpers\AuthHelpers;
use App\Models\Album;
use App\Models\User;
use App\Models\AlbumSong;

class AlbumsControllerTest extends TestCase
{

  protected function setUp()
  {
    parent::setUp();

    $songMock = new SongMock();

    $this->header = $songMock->mockUserToken();
  }

  /**
   * Test File Uplaod Success.
   *
   * @return void
   */
  public function testCreateAlbumSuccess()
  {
    $response = $this->post('/api/v1/songs/albums/create', [
      'title' => 'Album title',
      'description' => 'Album title'
    ], $this->header);

    $response->assertStatus(201);

    $response->assertJsonFragment([
      'message' => 'Album created',
    ]);
  }

  /**
   * Test File Uplaod Success.
   *
   * @return void
   */
  public function testCreateAlbumDuplicateError()
  {
    $album = Album::find(1);

    $token = AuthHelpers::jwtEncode(User::find($album->user_id));

    $header = [
      'Authorization' => $token
    ];

    $response = $this->post('/api/v1/songs/albums/create', [
      'title' => 'Album title',
      'description' => 'Album title'
    ], $header);
    
    $response->assertStatus(409);

    $response->assertJsonFragment([
      'message' => 'You already have an album with this title',
    ]);
  }

  public function testAddSongToAlbumSuccess()
  {
    $response = $this->post('/api/v1/songs/1/albums/1', [], $this->header);

    $response->assertStatus(201);

    $response->assertJsonFragment([
      'message' => 'Album created',
    ]);
  }

  public function testAddSongToAlbumDuplicateError()
  {
    $albumSong = AlbumSong::find(1);

    
    $token = AuthHelpers::jwtEncode(User::find($albumSong->user_id));
    
    $header = [
      'Authorization' => $token
    ];
    
    $response = $this->post('/api/v1/songs/' . $albumSong->song_id . '/albums/' . $albumSong->album_id, [], $header);

    $response->assertStatus(409);

    $response->assertJsonFragment([
      'message' => 'You already have an this song on your album',
    ]);
  }
}
