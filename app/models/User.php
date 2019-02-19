<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'firstName', 'lastName', 'password', 'email', 'phone', 'type', 'genre'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  public static $signupRules = [
    'firstName' => 'required|min:5|max:25',
    'lastName' => 'required|min:5|max:25',
    'email' => 'required|email',
    'password' => 'required|min:4|max:25',
  ];

  public static $signinRules = [
    'email' => 'required|email',
    'password' => 'required',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  // /**
  //  * Get the songs for a user.
  //  */
  // public function songs()
  // {
  //   return $this->hasMany('App\Models\Song', 'id');
  // }
}
