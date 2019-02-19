<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourite;
use App\Models\Song;

class FavouritesController extends Controller
{
  /**
   * Adds a song to a user's favourite list
   * 
   * @param {Object} Request
   * @param {Interger} $id
   */
  public function addFavourite(Request $request, $id)
  {
    if (!$id || (int)$id < 1) {
      return response()->json([
        'message' => 'Invalid ID',
      ], 400);
    }

    $song = Favourite::where('id', (int)$id)
      ->where('user_id', $request->userId)
      ->first();

    if($song) {
      return response()->json([
        'message' => 'Already have this song as a favourite',
      ], 409);
    }

    $favourite = Favourite::create([
      'user_id' => $request->userId,
      'song_id' => $id
    ]);

    return response()->json([
      'message' => 'Favourite added to list',
    ], 201);
  }

  /**
   * Removes a song to a user's favourite list
   * 
   * @param {Object} Request
   * @param {Interger} $id
   */
  public function removeFavourite(Request $request, $id)
  {
    if (!$id || (int)$id < 1) {
      return response()->json([
        'message' => 'Invalid ID',
      ], 400);
    }

    $song = Favourite::where('id', (int)$id)
      ->where('user_id', $request->userId)
      ->first();

    if($song && $song->delete()) {
      return response()->json([
        'message' => 'Favourite deleted from list',
      ], 200);
    }

    return response()->json([
      'message' => 'You don\'t have a favourite song with that id',
    ], 404);
  }

  /**
   * Get favourite song list
   * 
   * @param {Object} Request
   * @param {Interger} $id
   */
  public function getFavourites(Request $request)
  {
    $songIds = Favourite::where('user_id', $request->userId)->pluck('song_id')->toArray();

    $songs = Song::whereIn('id', $songIds)->get();
    
    return response()->json([
      'message' => 'incoming data',
      'favourites' => $songs
    ], 200);
  }
}
