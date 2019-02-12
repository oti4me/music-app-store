<?php

namespace App\helpers;

use Exception;
use Illuminate\Support\Facades\Storage;


class FileHelper
{
  /**
   * Upload a file to remote server
   * 
   * @param {object} $file
   * @return object
   */
  public static function uploadFile($file)
  {
    try{
      return Storage::put('files', $file);

    } catch(\Exception $e) {
      dd($e->getMessage());
    }
  }

  /**
   * Download a file from remote server
   * 
   * @param {object} $file
   * @return object
   */
  public static function downloadFile($url)
  {
    try {
      return Storage::download($url);

    } catch (\Exception $e) {
      dd($e->getMessage());
    }
  }
}