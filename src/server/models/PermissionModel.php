<?php

namespace Models;

use Core\Database;
use Entities\Permission;

class PermissionModel {
  /**
   * Find by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return Permission[] Permissions
   */
  public static function find(array $filter = null) {
    $permissions = [];
    $result = Database::find('Permission', $filter);
    while ($data = $result->fetch()) {
      $permissions[] = new Permission($data);
    }
    return $permissions;
  }
}
