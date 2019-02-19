<?php

namespace Tests\Feature\App\Http\Controller;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mock\UserMock;
use Illuminate\Support\Facades\Artisan;

class UsersControllerTest extends TestCase
{

  protected function setUp()
  {
    parent::setUp();

    $userMock = new UserMock();

    $this->staticUserDetails = $userMock->getStaticUserDetails();

    $this->incompleteUserDetails = $userMock->getincompleteUserDetails();

    $this->getwrongEmailUserDetails = $userMock->getwrongEmailUserDetails();
  }

  protected function clearDB()
  {
    \Artisan::call('migrate:fresh');
    \Artisan::call('migrate');
  }

  /**
   * Test User Signup Success.
   *
   * @return void
   */
  public function testUserSignupSuccess()
  {
    $this->clearDB();

    $response = $this->post('/api/v1/auth/signup', $this->staticUserDetails);

    $response->assertStatus(201);

    $response = $response->json();

    $this->assertEquals($response['user']['email'], $this->staticUserDetails['email']);
  }

  /**
   * Test User Signup Duplicate Error.
   *
   * @return void
   */
  public function testUserSignupDuplicateError()
  {
    $response = $this->post('/api/v1/auth/signup', $this->staticUserDetails);

    $response->assertStatus(409);

    $response->assertJsonFragment([
      'message' => 'A user with this email already exist',
    ]);
  }

  /**
   * Test User Signup Validation Error.
   *
   * @return void
   */
  public function testUserSignupValidationError()
  {
    $response = $this->post('/api/v1/auth/signup', []);

    $response->assertStatus(422);

    $response->assertJsonFragment([
      'email' => ["The email field is required."],
      'firstName' => ["The first name field is required."],
      'lastName' => ["The last name field is required."],
      'password' => ["The password field is required."],
    ]);
  }

  /**
   * Test User Signin Success.
   *
   * @return void
   */
  public function testUserSigninSuccess()
  {
    $response = $this->post('/api/v1/auth/signin', $this->staticUserDetails);

    $response->assertStatus(200);

    $response->assertJsonFragment([
      'message' => 'Login successful'
    ]);
  }

  /**
   * Test User Signin 401 Error.
   *
   * @return void
   */
  public function testUserSigninUnauthorizesError()
  {
    $response = $this->post('/api/v1/auth/signin', $this->getwrongEmailUserDetails);

    $response->assertStatus(401);

    $response->assertJsonFragment([
      'message' => 'User name or password not correct'
    ]);
  }

  /**
   * Test User Signin validation Error.
   *
   * @return void
   */
  public function testUserSigninValidationError()
  {
    $response = $this->post('/api/v1/auth/signin', []);

    $response->assertStatus(422);

    $response->assertJsonFragment([
      'email' => ['The email field is required.'],
      'password' => ["The password field is required."]
    ]);
  }
}
