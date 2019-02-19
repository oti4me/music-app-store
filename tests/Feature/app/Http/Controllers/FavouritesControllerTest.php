<?php

namespace Tests\Feature\App\Http\Controller;

use Tests\TestCase;
use Tests\Mock\SongMock;
use App\Models\Favourite;
use App\Models\User;
use App\helpers\AuthHelpers;




class FavouritesControllerTest extends TestCase
{

  protected function setUp()
  {
    parent::setUp();

    $songMock = new SongMock();

    $this->header = $songMock->mockUserToken();
  }

  /**
   * Test Add Favourite Success.
   *
   * @return void
   */
  public function testAddFavouriteSuccess()
  {
    $response = $this->post('/api/v1/songs/1/favourite', [], $this->header);

    $response->assertStatus(201);

    $response->assertJsonFragment([
      'message' => 'Favourite added to list',
    ]);
  }

  /**
   * Test Add Favourite validation Error.
   *
   * @return void
   */
  public function testAddFavValidationError()
  {
    $response = $this->post('/api/v1/songs/fwfwf/favourite', [], $this->header);

    $response->assertStatus(400);

    $response->assertJsonFragment([
      'message' => 'Invalid ID',
    ]);
  }

  /**
   * Test Add Favourite validation Error.
   *
   * @return void
   */
  public function testAddFavlDuplicateError()
  {
    $favourite = Favourite::all()[0];
    $user = User::find($favourite->user_id);
    $token = AuthHelpers::jwtEncode($user);

    $response = $this->post('/api/v1/songs/'. $favourite->id .'/favourite', [], [
      'Authorization' => $token
    ]);

    $response->assertStatus(409);

    $response->assertJsonFragment([
      'message' => 'Already have this song as a favourite',
    ]);
  }

  /**
   * Test Add Favourite validation Error.
   *
   * @return void
   */
  public function testRemoveFavouriteSuccess()
  {
    $favourite = Favourite::all()[0];
    $user = User::find($favourite->user_id);
    $token = AuthHelpers::jwtEncode($user);

    $response = $this->delete('/api/v1/songs/' . $favourite->id . '/favourite', [], [
      'Authorization' => $token
    ]);

    $response->assertStatus(200);

    $response->assertJsonFragment([
      'message' => 'Favourite deleted from list',
    ]);
  }

  /**
   * Test Add Favourite validation Error.
   *
   * @return void
   */
  public function testRemoveFavouriteValidationError()
  {
    $response = $this->delete('/api/v1/songs/fgdfgdf/favourite', [], $this->header);

    $response->assertStatus(400);

    $response->assertJsonFragment([
      'message' => 'Invalid ID',
    ]);
  }

  /**
   * Test Add Favourite validation Error.
   *
   * @return void
   */
  public function testRemoveFavouriteNotFoundError()
  {
    $response = $this->delete('/api/v1/songs/500/favourite', [], $this->header);

    $response->assertStatus(404);

    $response->assertJsonFragment([
      'message' => 'You don\'t have a favourite song with that id',
    ]);
  }

  /**
   * Test Add Favourite validation Error.
   *
   * @return void
   */
  public function testGetFavourite()
  {
    $response = $this->get('/api/v1/songs/favourites', $this->header);

    $response->assertStatus(200);

    $response->assertJsonFragment([
      'message' => 'incoming data',
    ]);
  }

}
