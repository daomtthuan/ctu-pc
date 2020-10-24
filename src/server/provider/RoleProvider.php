<?php

namespace Provider;

use Core\Database;
use Entity\Role;
use Entity\User;

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
   * Find roles that be owned by user
   * 
   * @param User $user Owned by user
   * @param array|null $filter Finding filter
   * 
   * @return Role[] Roles
   */
  public static function findOwnedByUser(User $user, array $filter = null) {
    $roleReferenceFilters = Database::getInstance()->createReferenceFilters('Role', $filter);
    $userReferenceFilters = [
      Database::getInstance()->createReferenceFilter('User', 'id', $user->getId())
    ];

    $result = Database::getInstance()->findJoin('Role', [
      Database::getInstance()->createReference('Permission', 'Permission', 'idRole', 'Role', 'id', Database::INNER_JOIN),
      Database::getInstance()->createReference('User', 'User', 'id', 'Permission', 'idUser', Database::INNER_JOIN),
    ], array_merge($userReferenceFilters, $roleReferenceFilters));

    $roles = [];
    foreach ($result as $data) {
      $roles[] = new Role($data);
    }
    return $roles;
  }
}
