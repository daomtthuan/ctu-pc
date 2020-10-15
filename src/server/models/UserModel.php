<?php

namespace Models;

use Core\Database;
use Entities\User;

class UserModel {
  /**
   * Find by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return User[] Users
   */
  public static function find(array $filter = null) {
    $users = [];
    $result = Database::find('User', $filter);
    while ($data = $result->fetch()) {
      $users[] = new User($data);
    }
    return $users;
  }

  /**
   * Add new
   * 
   * @param User $user Adding user
   */
  public static function add(User $user) {
    $users = [];
    $result = Database::find('User', $filter);
    while ($data = $result->fetch()) {
      $users[] = new User($data);
    }
    return $users;
  }
}
