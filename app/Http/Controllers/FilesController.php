<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\helpers\FileHelper;
use App\Models\File;

class FilesController extends Controller
{
  /**
   * Grant a user access into his account
   * 
   * @return User
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
}
