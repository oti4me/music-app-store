<?php

namespace App\helpers;

use Exception;
use Illuminate\Support\Facades\Storage;


class FileHelper
{
  /**
   * Uploads a file to a remote server
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
}