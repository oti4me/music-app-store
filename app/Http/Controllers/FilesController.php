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
        'user_id' => $request->userId,
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
   * Downlaod a file from the remote server
   * 
   * @param Request $request
   * @return  $file
   */
  public function downloadFile(Request $request)
  {
    $this->validate($request, File::$urlRules);

    $response = FileHelper::downloadFile($request->input('url'));

    if ($response) {
        return $response;
    }

    return response()->json([
      'message' => 'Error downloading file, try again later',
    ], 500);
  }

  /**
   * delete file from the remote server
   * 
   * @param Request $request
   * @return  $file
   */
  public function deleteFile(Request $request)
  {
    $this->validate($request, File::$urlRules);

    $file = File::where('url', $request->input('url'))
                ->where('user_id', $request->userId)
                ->first();

    if ($file && $file->delete()) {
      if (FileHelper::deleteFile($request->input('url'))) {
        return response()->json([
          'message' => 'File deleted successfully',
        ], 203);
      }
    } else {
      return response()->json([
          'message' => 'File not found for this user',
        ], 404);
    }

    return response()->json([
      'message' => 'Error deleting file, try again later',
    ], 500);
  }
}
