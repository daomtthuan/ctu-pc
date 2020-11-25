<?php

namespace Provider;

use Core\Database;
use Entity\Role;

/** Role provider */
class RoleProvider {
  public const ADMIN_ID = 1;
  public const USER_ID = 2;

  /**
   * Find roles by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return Role[] Roles
   */
  public static function find(array $filter = null) {
    $roles = [];
    foreach (Database::getInstance()->find('Role', $filter) as $data) {
      $roles[] = new Role($data);
    }
    return $roles;
  }

  /**
   * Find roles that be owned by Account
   * 
   * @param int $idAccount Id of owned by Account
   * @param array|null $filter Finding filter
   * 
   * @return Role[] Roles
   */
  public static function findOwnedByAccount(int $idAccount, array $filter = null) {
    $roleReferenceFilters = Database::getInstance()->createReferenceFilters('Role', $filter);
    $accountReferenceFilters = [
      Database::getInstance()->createReferenceFilter('Account', 'id', $idAccount)
    ];

    $result = Database::getInstance()->findJoin('Role', [
      Database::getInstance()->createReference('Permission', 'Permission', 'idRole', 'Role', 'id', Database::JOIN_INNER),
      Database::getInstance()->createReference('Account', 'Account', 'id', 'Permission', 'idAccount', Database::JOIN_INNER),
    ], array_merge($accountReferenceFilters, $roleReferenceFilters));

    $roles = [];
    foreach ($result as $data) {
      $roles[] = new Role($data);
    }
    return $roles;
  }

  /**
   * Edit Role
   * 
   * @param Role $role Edited Role
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Role $role) {
    $data = $role->jsonSerialize();
    unset($data['id']);
    return Database::getInstance()->edit('Role', $role->getId(), $data);
  }
}
