<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\helpers\UserHelper;
use App\helpers\AuthHelpers;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
  /**
   * Creates a user account on the applciation
   * 
   * @return User
   */
  public function userSignup(Request $request)
  {
    $this->validate($request, User::$signupRules);

    $userDetails = UserHelper::getFormatedUserDetails($request->input());

    if($request->input('type')) {
      $userDetails['type'] = $request->input('type');
    }

    $existingUser = User::where('email', $userDetails['email'])->first();

    if ($existingUser) {
      return response()->json([
        'message' => 'A user with this email already exist',
      ], 409);
    }
    
    $user = User::create($userDetails);

    $token = AuthHelpers::jwtEncode($user);

    $user = UserHelper::getSignedInUserDetails($user);

    return response()->json([
      'message' => 'User account create successfully',
      'token' => $token,
      'user' => $user,
    ], 201);
  }

  /**
   * Grant a user access into his account
   * 
   * @return User
   */
  public function userSignin(Request $request)
  {
    $this->validate($request, User::$signinRules);

    $user = User::where('email', $request->input('email'))->first();

    if ($user) {
      if(Hash::check($request->input('password'), $user->password)) {

        $token = AuthHelpers::jwtEncode($user);

        $user = UserHelper::getSignedInUserDetails($user);

        
  
        return response()->json([
          'message' => 'Login successful',
          'user' => $user,
          'token' => $token,
        ], 200);
      }
    }

    return response()->json([
      'message' => 'User name or password not correct',
    ], 401);
  }
}
