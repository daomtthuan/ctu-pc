<?php

namespace Provider;

use Core\Database;
use Entity\Permission;

/** Permission provider */
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
   * @param Permission $permission Created permission
   * 
   * @return int Id permission
   */
  public static function create(Permission $permission) {
    $data = $permission->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Permission', $data);
  }

  /**
   * Remove permission by filter
   * 
   * @param array|null $filter Removing filter
   * 
   * @return int Number removed permission
   */
  public static function remove(array $filter = null) {
    return Database::getInstance()->remove('Permission', $filter);
  }
}
