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

    if ($fileUrl = FileHelper::uploadFile($request->file('file'))) {
      $file = File::create([
        'user_id' => $request->userId,
        'name' => $request->input('name'),
        'url' => $fileUrl,
      ]);

      if($file) {
        return response()->json([
          'message' => 'File uploaded',
          'file' => $file
        ], 201);
      }
    }
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

    if ($response = FileHelper::downloadFile($request->input('url'))) { 
            
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
        ], 204);
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
  public function getFiles(Request $request) {

    $files = File::all();

    return response()->json([
      'message' => 'in coming files list',
      'files' => $files,
    ], 200);
  }

  /**
   * get my uploaded file list
   * 
   * @param Request $request
   * @return  $file
   */
  public function getMyFiles(Request $request)
  {
    $files = File::where('user_id', $request->userId)->get();

    return response()->json([
      'message' => 'in coming files list',
      'files' => $files,
    ], 200);
  }
}
