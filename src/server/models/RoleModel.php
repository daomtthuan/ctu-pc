<?php

namespace Models;

use Core\Database;
use Entities\Role;

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
    $result = Database::find('Role', $filter);
    while ($data = $result->fetch()) {
      $roles[] = new Role($data);
    }
    return $roles;
  }

  /**
   * Find roles that be owned by user
   * 
   * @param int $idUser Id User
   * @param array|null $filter Finding filter
   * 
   * @return Role[] Roles
   */
  public static function findOwnedByUser(int $idUser, array $filter = null) {
    $roles = [];
    $referenceFilters = array_merge(
      [
        Database::createReferenceFilter('User', 'id', $idUser)
      ],
      Database::createReferenceFilters('Role', $filter)
    );

    $result = Database::findJoin('Role', [
      Database::createReference('Permission', 'Permission', 'idRole', 'Role', 'id', Database::INNER_JOIN),
      Database::createReference('User', 'User', 'id', 'Permission', 'idUser', Database::INNER_JOIN),
    ], $referenceFilters);
    while ($data = $result->fetch()) {
      $roles[] = new Role($data);
    }
    return $roles;
  }
}
