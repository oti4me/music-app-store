<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\helpers\UserHelper;
use App\helpers\AuthHelpers;

class UsersController extends Controller
{
  /**
   * Creates a user account on the applciation
   * 
   * @return User
   */
  public function userSignup(Request $request)
  {

    $errors = UserHelper::validateSignup($request->input());

    if(count($errors) > 0) {
      return response()->json([
        'message' => $errors,
      ], 400);
    }

    $userDetails = UserHelper::getFormatedUserDetails($request->input());

    $existingUser = User::where('email', $userDetails['email'])->first();

    if ($existingUser) {
      return response()->json([
        'message' => 'A user with this email already exist',
      ], 409);
    }

    $user = User::create($userDetails);

    $token = AuthHelpers::jwtEncode($user);

    return response()->json([
      'message' => 'User account create successfully',
      'token' => $token,
    ], 201);
  }
}
