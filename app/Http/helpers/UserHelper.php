<?php

namespace App\helpers;

use Exception;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserHelper
{
  /**
   * Create a new token.
   * 
   * @param {object} $user
   * @return string
   */
  public static function getFormatedUserDetails(array $userInput)
  {
    return [
      'firstName' => $userInput['firstName'],
      'lastName'  => $userInput['lastName'],
      'email'     => $userInput['email'],
      'password'  => Hash::make($userInput['password']),
      'phone'     => @$userInput['phone'],
      'genre'     => @ucfirst($userInput['genre']),
    ];
  }

  /**
   * Logined in user details.
   * 
   * @param {object} $user
   * @return {Array} user
   */
  public static function getSignedInUserDetails($user)
  {
    return [
      'firstName' => $user->firstName,
      'lastName' => $user->lastName,
      'email' => $user->email,
      'phone' => @$user->phone,
      'genre' => $user->genre,
      'type' => $user->type
    ];
  }

  /**
   * Get a user by ID
   * 
   * @param {Interger} $id
   * @return {Object} User
   */
  public static function getUserById($id) {
    return User::find($id);
  }
}
