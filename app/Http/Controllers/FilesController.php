<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\helpers\FileHelper;
use App\Models\File;

class FilesController extends Controller
{
  /**
   * Uplaod file the a remote server
   * 
   * @param Request $request
   * @return {string} file url
   */
  public function uploadFile(Request $request)
  {
    $this->validate($request, File::$uploadRules);

    $fileUrl = FileHelper::uploadFile($request->file('file'));

    if ($fileUrl) {
      $file = File::create([
        'user_id' => 1,
        'name' => $request->input('name'),
        'url' => $fileUrl,
      ]);

      if($file) {
        return response()->json([
          'message' => 'File uploaded',
        ], 201);
      }
    }

    return response()->json([
      'message' => 'Error uploading file, try again later',
    ], 500);
  }

  /**
   * Uplaod file the a remote server
   * 
   * @param Request $request
   * @return  $file
   */
  public function downloadFile(Request $request)
  {
    $this->validate($request, File::$downloadRules);

    $response = FileHelper::downloadFile($request->input('url'));

    if ($response) {
        return $response;
    }

    return response()->json([
      'message' => 'Error downloading file, try again later',
    ], 500);
  }
}
