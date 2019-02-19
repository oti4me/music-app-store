<?php

namespace App\helpers;

use Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\Song;

class SongsHelper
{
  /**
   * Upload a file to remote server
   * 
   * @param {object} $file
   * @return object
   */
  public static function uploadSong($file)
  {
    try{
      return Storage::put('public/songs', $file);

    } catch(\Exception $e) {
      return false;
    }
  }

  public static function getFormatedSongDetails($songDetails) {
    return [
      'title' => $songDetails['title'],
      'genre' => $songDetails['genre'],
      'artist' => $songDetails['artist'],
    ];
  }

  public static function getSong() {
    return Song::all()[0];
  }

  /**
   * Download a file from remote server
   * 
   * @param {object} $file
   * @return object
   */
  public static function downloadSong($url)
  {
    try {
      return Storage::download($url);

    } catch (\Exception $e) {
      return false;
    }
  }

  /**
   * Delete a file from remote server
   * 
   * @param {object} $file
   * @return object
   */
  public static function deleteSong($url)
  {
    try {
      return Storage::delete($url);

    } catch (\Exception $e) {
      return false;
    }
  }
}
