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

    $fileDetails = SongsHelper::getFormatedSongDetails($request->input());

    if ($fileUrl = SongsHelper::uploadSong($request->file('file'))) {
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

      return response()->json([
        'message' => 'File Downloaded',
        'File' => $response,
      ], 200);
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
      ->get();

    return response()->json([
      'message' => 'in coming songs list',
      'songs' => $songs,
    ], 200);
  }
}
