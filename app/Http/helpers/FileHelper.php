<?php

namespace App\helpers;

use Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

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
      return false;
    }
  }

  public static function getFile() {
    return File::all()[0];
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
      return false;
    }
  }

  /**
   * Delete a file from remote server
   * 
   * @param {object} $file
   * @return object
   */
  public static function deleteFile($url)
  {
    try {
      return Storage::delete($url);

    } catch (\Exception $e) {
      return false;
    }
  }
}
