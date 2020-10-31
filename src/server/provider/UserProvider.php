<?php

namespace Provider;

use Core\Database;
use Entity\User;

class UserProvider {
  /**
   * Find user by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return User[] Users
   */
  public static function find(array $filter = null) {
    $users = [];
    foreach (Database::getInstance()->find('User', $filter) as $data) {
      $users[] = new User($data);
    }
    return $users;
  }

  /**
   * Create user
   * 
   * @param User $user Added user
   * 
   * @return bool True if success, otherwise false
   */
  public static function create(User $user) {
    $data = $user->getData();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('User', $data) == 1;
  }

  /**
   * Edit user
   * 
   * @param User $user Edited user
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(User $user) {
    $data = $user->getData();
    unset($data['id']);
    return Database::getInstance()->edit('User', $user->getId(), $data) == 1;
  }
}
