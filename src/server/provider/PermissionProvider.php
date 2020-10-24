<?php

namespace Provider;

use Core\Database;
use Entity\Permission;

class PermissionProvider {
  /**
   * Find by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return Permission[] Permissions
   */
  public static function find(array $filter = null) {
    $permissions = [];
    foreach (Database::getInstance()->find('Permission', $filter) as $data) {
      $permissions[] = new Permission($data);
    }
    return $permissions;
  }

  /**
   * Add instance
   * 
   * @param Permission $permission Added permission
   * 
   * @return bool True if success, otherwise false
   */
  public static function add(Permission $permission) {
    $data = $permission->getData();
    unset($data['id'], $data['state']);
    return Database::getInstance()->add('Permission', $data) == 1;
  }
}
