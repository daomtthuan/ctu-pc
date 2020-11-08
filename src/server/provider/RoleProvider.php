<?php

namespace Provider;

use Core\Database;
use Entity\Role;
use Entity\Account;

class RoleProvider {
  public const ADMIN_ID = 1;
  public const USER_ID = 2;

  /**
   * Find by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return Role[] Permissions
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
   * @param Account $account Owned by Account
   * @param array|null $filter Finding filter
   * 
   * @return Role[] Roles
   */
  public static function findOwnedByAccount(Account $account, array $filter = null) {
    $roleReferenceFilters = Database::getInstance()->createReferenceFilters('Role', $filter);
    $accountReferenceFilters = [
      Database::getInstance()->createReferenceFilter('Account', 'id', $account->getId())
    ];

    $result = Database::getInstance()->findJoin('Role', [
      Database::getInstance()->createReference('Permission', 'Permission', 'idRole', 'Role', 'id', Database::INNER_JOIN),
      Database::getInstance()->createReference('Account', 'Account', 'id', 'Permission', 'idAccount', Database::INNER_JOIN),
    ], array_merge($accountReferenceFilters, $roleReferenceFilters));

    $roles = [];
    foreach ($result as $data) {
      $roles[] = new Role($data);
    }
    return $roles;
  }
}
