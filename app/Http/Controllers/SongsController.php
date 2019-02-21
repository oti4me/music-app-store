<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\helpers\SongsHelper;
use App\Models\Song;

class SongsController extends Controller
{
  /**
   * Uplaod file the a remote server
   * 
   * @param Request $request
   * @return {string} file url
   */
  public function uploadSong(Request $request)
  {
    $this->validate($request, Song::$uploadRules);

    $ext = $request->file('file')->getClientOriginalExtension();

    if($ext !== 'mp3') {
      return response()->json([
        'message' => 'File must be an mp3 file',
      ], 422);
    }

    $songExist = Song::where('title', $request->input('title'))
        ->where('user_id', $request->userId)->first();

    if($songExist) {
      return response()->json([
        'message' => 'You already have a song with this title',
      ], 409);
    }

    $fileDetails = SongsHelper::getFormatedSongDetails($request->input());

    $name = str_replace(' ', '_', $fileDetails['title']);
    $name .= '.' . $ext;

    if ($fileUrl = SongsHelper::uploadSong($request->file('file'), $name)) {
      $fileDetails['user_id'] = $request->userId;
      $fileDetails['url'] = $fileUrl;

      $file = Song::create($fileDetails);

      return response()->json([
        'message' => 'File uploaded',
        'file' => $file
      ], 201);
    }
  }

  /**
   * Downlaod a file from the remote server
   * 
   * @param Request $request
   * @return  $file
   */
  public function downloadSong(Request $request)
  {
    $this->validate($request, Song::$urlRules);

    if ($response = SongsHelper::downloadSong($request->input('url'))) {

      return $response;
      // return response()->json([
      //   'message' => 'File Downloaded',
      //   'File' => $response,
      // ], 200);
    }

    return response()->json([
      'message' => 'This file is not found',
    ], 404);
  }

  /**
   * delete file from the remote server
   * 
   * @param Request $request
   * @return  $file
   */
  public function deleteSong(Request $request, $id)
  {
    $url = '';

    if (!$id || (int)$id < 1) {
      return response()->json([
        'message' => 'Invalid ID',
      ], 400);
    }

    $song = Song::where('id', (int)$id)
      ->where('user_id', $request->userId)
      ->first();

    if ($song) {
      $url = $song->url;
    }

    if ($song && $song->delete()) {
      if (SongsHelper::deleteSong($url)) {
        return response()->json([
          'message' => 'File deleted successfully',
        ], 200);
      }
    }

    return response()->json([
      'message' => 'File not found for this user',
    ], 404);
  }

  /**
   * get uploaded file list
   * 
   * @param Request $request
   * @return  $file
   */
  public function getSongs(Request $request)
  {
    $songs = Song::all();

    return response()->json([
      'message' => 'in coming songs list',
      'songs' => $songs,
    ], 200);
  }

  /**
   * get my uploaded file list
   * 
   * @param Request $request
   * @return  $file
   */
  public function getMySongs(Request $request)
  {
    $files = Song::where('user_id', $request->userId)->get();

    return response()->json([
      'message' => 'in coming songs list',
      'songs' => $files,
    ], 200);
  }

  /**
   * get my uploaded file list
   * 
   * @param Request $request
   * @return  $file
   */
  public function searchSongs(Request $request)
  {
    $searchTerm = $request->input('searchTerm');
    
    $songs = Song::where('title', 'ILIKE', '%' . $searchTerm . '%')
      ->orWhere('genre', 'ILIKE', '%' . $searchTerm . '%')
      ->orWhere('artist', 'ILIKE', '%' . $searchTerm . '%')
      ->get();

    return response()->json([
      'message' => 'in coming songs list',
      'songs' => $songs,
    ], 200);
  }
}
