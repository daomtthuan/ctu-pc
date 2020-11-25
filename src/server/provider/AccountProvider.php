<?php

namespace Provider;

use Core\Database;
use Entity\Account;

/** Account provider */
class AccountProvider {
  /**
   * Find Account by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return Account[] Accounts
   */
  public static function find(array $filter = null) {
    $accounts = [];
    foreach (Database::getInstance()->find('Account', $filter) as $data) {
      $accounts[] = new Account($data);
    }
    return $accounts;
  }

  /**
   * Find Accounts own role
   * 
   * @param int $idRole Id of own Role
   * @param array|null $filter Finding filter
   * 
   * @return Account[] Accounts
   */
  public static function findOwnRole(int $idRole, array $filter = null) {
    $accountReferenceFilters = Database::getInstance()->createReferenceFilters('Account', $filter);
    $roleReferenceFilters = [
      Database::getInstance()->createReferenceFilter('Role', 'id', $idRole)
    ];

    $result = Database::getInstance()->findJoin('Account', [
      Database::getInstance()->createReference('Permission', 'Permission', 'idAccount', 'Account', 'id', Database::JOIN_INNER),
      Database::getInstance()->createReference('Role', 'Role', 'id', 'Permission', 'idRole', Database::JOIN_INNER),
    ], array_merge($roleReferenceFilters, $accountReferenceFilters));

    $accounts = [];
    foreach ($result as $data) {
      $accounts[] = new Account($data);
    }
    return $accounts;
  }

  /**
   * Find Accounts not own role
   * 
   * @param int $idRole Id of own Role
   * @param array|null $filter Finding filter
   * 
   * @return Account[] Accounts
   */
  public static function findNotOwnRole(int $idRole, array $filter = null) {
    $referenceFilters = [
      Database::getInstance()->createReferenceFilter('Role', 'id', $idRole)
    ];

    $result = Database::getInstance()->findInJoin('Account', 'id', false, [
      Database::getInstance()->createReference('Permission', 'Permission', 'idAccount', 'Account', 'id', Database::JOIN_INNER),
      Database::getInstance()->createReference('Role', 'Role', 'id', 'Permission', 'idRole', Database::JOIN_INNER),
    ], $referenceFilters, $filter);

    $accounts = [];
    foreach ($result as $data) {
      $accounts[] = new Account($data);
    }
    return $accounts;
  }

  /**
   * Create Account
   * 
   * @param Account $account Created Account
   * 
   * @return int Id account
   */
  public static function create(Account $account) {
    $data = $account->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Account', $data);
  }

  /**
   * Edit Account
   * 
   * @param Account $account Edited Account
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Account $account) {
    $data = $account->jsonSerialize();
    unset($data['id']);
    return Database::getInstance()->edit('Account', $account->getId(), $data);
  }

  /**
   * Remove account by filter
   * 
   * @param array|null $filter Removing filter
   * 
   * @return int Number removed account
   */
  public static function remove(array $filter = null) {
    return Database::getInstance()->remove('Account', $filter);
  }
}
