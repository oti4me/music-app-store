<?php

namespace App\helpers;

use Exception;
use Illuminate\Support\Facades\Hash;

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
      'phone'     => $userInput['phone']
    ];
  }

  public static function validateSignin($input){
    
    $errors = [];
    if (!self::validateEmail(self::test_input(@$input['email']))) {
      $errors[] = "A valid emmail is required!!";
    }

    if (!self::validatePaaword(self::test_input(@$input['password']))) {
      $errors[] = "Password is required, and must be more than 3 characters";
    }

    return $errors;
  }

  /**
   * Validate user input.
   * 
   * @param {array} $input
   * @return array
   */
  public static function validateSignup($input)
  {
    $errors = [];
      if(!self::validateEmail(self::test_input(@$input['email']))) {
        $errors[] = "A valid emmail is required!!";
      }

      if (!self::validateName(self::test_input(@$input['firstName']))) {
        $errors[] = "First Name is required and must me more than 2 characters";
      }

      if (!self::validateName(self::test_input(@$input['lastName']))) {
        $errors[] = "First Name is required and must me more than 2 characters";
      }

      if (!self::validatePaaword(self::test_input(@$input['password']))) {
        $errors[] = "Password is required, and must be more than 3 characters";
      }

      return $errors;
  }

  private static function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  private static function validatePaaword($password)
  {
    if ($password && strlen($password) > 3) {
      return true;
    } else return false;
  }

  private static function validateName($name)
  {
    if ($name && strlen($name) > 3) {
      return true;
    } else return false;
  }

  private static function validateEmail($email)
  {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return true;
    } else return false;
  }
}
