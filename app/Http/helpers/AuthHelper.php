<?php

namespace App\helpers;

use Exception;
use App\Models\User;
use \Firebase\JWT\JWT;

class AuthHelpers
{
  /**
   * Create a new token.
   * 
   * @param {object} $user
   * @return string
   */
  public static function jwtEncode(User $user)
  {
    $payload = [
      'iss' => "Music Store",
      'sub' => $user->id,
      'iat' => strtotime("now"),
      'exp' => strtotime("+ 1 week")
    ];

    return JWT::encode($payload, env('JWT_SECRET'));
  }

  /**
   * Validate token.
   * 
   * @param {String} $token
   * @return string
   * @throws Exception
   */
  public static function jwtDecode($token)
  {
    try {
      return JWT::decode($token, env('JWT_SECRET'), array('HS256'));
    } catch (Exception $e) {
      abort(401);;
    }
  }
}
