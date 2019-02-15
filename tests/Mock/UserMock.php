<?php

namespace Tests\Mock;

use Illuminate\Contracts\Console\Kernel;
use Faker\Factory as Faker;

class UserMock
{
  public function __construct()
  {
    $this->faker = Faker::create();
  }

  /**
   * User detials
   *
   * @return {array} user
   */
  public function getStaticUserDetails()
  {
    return [
      "firstName"   => 'Henry',
      "lastName"    => 'Otighe',
      "email"       => 'oti4me@gmail.com',
      "password"    => 'securepassworddoesnthurt',
      "phone"       => '911',
    ];
  }

  /**
   * User detials
   *
   * @return {array} user
   */
  public function getRandomUserDetails()
  {
    return [
      "firstName" => $this->faker->firstName,
      "lastName" => $this->faker->lastName,
      "email" => $this->faker->email,
      "password" => $this->faker->password,
      "phone" => $this->faker->phoneNumber,
    ];
  }

  public function getincompleteUserDetails() {
    return [
      "firstName" => '',
      "lastName" => $this->faker->lastName,
      "email" => 'oti4me@gmail',
      "password" => $this->faker->password,
      "phone" => $this->faker->phoneNumber,
    ];
  }

  public function getwrongEmailUserDetails() {
    return [
      "email" => 'incorrectemail@gmail.com',
      "password" => $this->faker->password,
    ];
  }
}