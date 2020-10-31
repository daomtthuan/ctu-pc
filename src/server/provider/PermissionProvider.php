<?php

namespace Provider;

use Core\Database;
use Entity\Permission;

class PermissionProvider {
  /**
   * Find permission by filter
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
   * Create permission
   * 
   * @param Permission $permission Added permission
   * 
   * @return bool True if success, otherwise false
   */
  public static function create(Permission $permission) {
    $data = $permission->getData();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Permission', $data) == 1;
  }
}
