<?php

namespace Tests\Feature\App\Http\Controller;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mock\FileMock;
use Illuminate\Support\Facades\Artisan;
use App\Helpers\AuthHelpers;
use App\Helpers\UserHelper;
use App\Helpers\FileHelper;

class FilessControllerTest extends TestCase
{

  protected function setUp()
  {
    parent::setUp();

    $fileMock = new FileMock();

    $this->header = $fileMock->mockUserToken();

    $this->fileDetails = $fileMock->fileDetails();

    $this->deleteFileDetails = $fileMock->deleteFileDetails();

    $this->invalidFileDetails = $fileMock->invalidFileDetails();

    $this->deleteFileNotFoundDetails = $fileMock->deleteFileNotFoundDetails();
  }

  /**
   * Test File Uplaod Success.
   *
   * @return void
   */
  public function testFileUploadSuccess()
  {
    $response = $this->post('/api/v1/files', $this->fileDetails, $this->header);

    $response->assertStatus(201);

    $response->assertJsonFragment([
      'message' => 'File uploaded',
    ]);
  }

  /**
   * Test File upload validation Error.
   *
   * @return void
   */
  public function testFileUploadValidationError()
  {
    $response = $this->post('/api/v1/files', $this->invalidFileDetails, $this->header);

    $response->assertStatus(422);

    $response->assertJsonFragment([
      'file' => ['The file must be a file.'],
    ]);
  }

  /**
   * Test File upload validation Error.
   *
   * @return void
   */
  public function testFileUploadAuthenticationError()
  {
    $header = [
      'Authorization' => 'thisisafaketoken'
    ];

    $response = $this->post('/api/v1/files', $this->invalidFileDetails, $header);

    $response->assertStatus(401);

    $response->assertJsonFragment([
      'message' => 'Unauthenticated',
    ]);
  }

  /**
   * Test Fetch Files.
   *
   * @return void
   */
  public function testFetchFiles()
  {
    $response = $this->get('/api/v1/files', $this->header);

    $response->assertStatus(200);

    $response->assertJsonFragment([
      'message' => 'in coming files list',
    ]);
  }

  /**
   * Test Fetch My Files.
   *
   * @return void
   */
  public function testFetchMyFiles()
  {
    $file = FileHelper::getFile();

    $user = UserHelper::getUserById($file->user_id);

    $token = AuthHelpers::jwtEncode($user);

    $header = [
      'Authorization' => $token
    ];

    $response = $this->get('/api/v1/files/myfiles', $header);

    $response->assertStatus(200);

    $response->assertJsonFragment([
      'message' => 'in coming files list',
    ]);
  }


  /**
   * Test Delete File Seccess.
   *
   * @return void
   */
  public function testDownloadFileSuccess()
  {
    $files = FileMock::getFilesFromDB()[0];
    
    $response = $this->get('/api/v1/files/download?url='. $files->url, $this->header);

    $response->assertStatus(200);
  }

  /**
   * Test Delete File Seccess.
   *
   * @return void
   */
  public function testDownloadFileFailure()
  {
    $files = "pathtononeexistingfile";

    $response = $this->get('/api/v1/files/download?url=' . $files, $this->header);

    $response->assertStatus(404);

    $response->assertJsonFragment([
      'message' => 'This file is not found',
    ]);
  }

  /**
   * Test Delete File Seccess.
   *
   * @return void
   */
  public function testDeleteFileSuccess()
  {
    $file = FileHelper::getFile();
    
    $user = UserHelper::getUserById($file->user_id);

    $token = AuthHelpers::jwtEncode($user);

    $header = [
      'Authorization' => $token
    ];
    
    $request = [
      'url' => $file->url
    ];
    
    $response = $this->delete('/api/v1/files', $request, $header);

    $response->assertStatus(204);

  }

  /**
   * Test Delete File Not Found Error.
   *
   * @return void
   */
  public function testDeleteFileNotFound()
  {
    $response = $this->delete('/api/v1/files', $this->deleteFileNotFoundDetails, $this->header);

    $response->assertStatus(404);

    $response->assertJsonFragment([
      'message' => 'File not found for this user',
    ]);
  }

  /**
   * Test Delete File Validation Error.
   *
   * @return void
   */
  public function testDeleteFileValidationError()
  {
    $response = $this->delete('/api/v1/files', $this->fileDetails, $this->header);

    $response->assertStatus(422);

    $response->assertJsonFragment([
      'url' => ['The url field is required.'],
    ]);
  }
}
