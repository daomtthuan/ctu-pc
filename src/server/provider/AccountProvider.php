<?php

namespace Provider;

use Core\Database;
use Entity\Account;

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
   * Create Account
   * 
   * @param Account $account Added Account
   * 
   * @return int Id account
   */
  public static function create(Account $account) {
    $data = $account->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Account', $data) == 1;
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
    return Database::getInstance()->edit('Account', $account->getId(), $data) == 1;
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
