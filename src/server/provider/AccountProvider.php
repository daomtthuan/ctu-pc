<?php

namespace Provider;

use Core\Database;
use Entity\Account;
use Entity\Permission;
use Exception;
use Plugin\HtmlPlugin;
use Plugin\MailPlugin;

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
   * @param bool $sendEmail Send account to email or not
   * 
   * @return bool True if success, otherwise false
   */
  public static function create(Account $account, bool $sendEmail = false) {
    return Database::getInstance()->doTransaction(function ($account, $sendEmail) {
      $data = $account->jsonSerialize();
      $data['password'] = password_hash($account->getPassword(), PASSWORD_BCRYPT);
      unset($data['id'], $data['state']);

      $id = Database::getInstance()->create('Account', $data);

      PermissionProvider::create(new Permission([
        'id' => null,
        'idAccount' => $id,
        'idRole' => RoleProvider::USER_ID,
        'state' => null
      ]));

      if ($sendEmail) {
        $h1 = fn ($name) => HtmlPlugin::getInstance()->createElement($name);
        $h2 = fn ($name, $content) => HtmlPlugin::getInstance()->createElement($name, $content);
        $h3 = fn ($name, $properties) => HtmlPlugin::getInstance()->createElement($name, null, $properties);

        MailPlugin::getInstance()->sendHtml(
          $account->getEmail(),
          $account->getFullName(),
          'Đăng ký tài khoản CTU PC SHOP',
          $h2('div', [
            $h2('p', [
              $h2('span', 'Xin chào '),
              $h2('strong', $account->getFullName()),
              $h2('span', ','),
              $h1('br'),
              $h2('span', 'Quá trình tạo tài khoản đã thành công. Chào mừng bạn đến với CTU PC SHOP!'),
              $h1('br'),
              $h2('span', 'Giờ đây, bạn có thể sử dụng tài khoản sau để đăng nhập:'),
            ]),
            $h2('form', [
              $h2('label', 'Tên đăng nhập:', ['for' => 'username']),
              $h1('br'),
              $h3('input', ['id' => 'username', 'value' => $account->getUsername()]),
              $h1('br'),
              $h2('label', 'Mật khẩu:', ['for' => 'password']),
              $h1('br'),
              $h3('input', ['id' => 'password', 'value' => $account->getPassword()]),
            ]),
            $h2('p', 'Trân trọng'),
            $h1('hr'),
            $h2('p', [
              $h2('em', [
                $h2('strong', 'Lưu ý: '),
                $h2('span', 'Vui lòng đổi mật khẩu ngay vào lần truy cập đầu tiên và tuyệt đối không để cho ai biêt được thông tin tài khoản.'),
                $h1('br'),
                $h2('span', 'Đây là email tự động, không trả lời vào email này.'),
              ])
            ]),
          ])
        );
      }
    }, $account, $sendEmail);
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
   * @param int $id Id account
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(int $id) {
    return Database::getInstance()->doTransaction(function ($id) {
      Database::getInstance()->remove('Review', ['idAccount' => $id]);
      Database::getInstance()->remove('Event', ['idAccount' => $id]);
      Database::getInstance()->remove('Permission', ['idAccount' => $id]);
      if (Database::getInstance()->remove('Account', ['id' => $id]) != 1) {
        throw new Exception('Not found account');
      }
    }, $id);
  }
}
