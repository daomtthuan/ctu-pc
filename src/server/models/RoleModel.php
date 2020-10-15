<?php

namespace Models;

use Core\Database;
use Entities\Role;
use Entities\User;

class RoleModel {
  /**
   * Find by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return Role[] Permissions
   */
  public static function find(array $filter = null) {
    $roles = [];
    foreach (Database::find('Role', $filter) as $data) {
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
    $roleReferenceFilters = Database::createReferenceFilters('Role', $filter);
    $userReferenceFilters = [
      Database::createReferenceFilter('User', 'id', $user->getId())
    ];

    $result = Database::findJoin('Role', [
      Database::createReference('Permission', 'Permission', 'idRole', 'Role', 'id', Database::INNER_JOIN),
      Database::createReference('User', 'User', 'id', 'Permission', 'idUser', Database::INNER_JOIN),
    ], array_merge($userReferenceFilters, $roleReferenceFilters));

    $roles = [];
    foreach ($result as $data) {
      $roles[] = new Role($data);
    }
    return $roles;
  }
}
