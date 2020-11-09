<?php

namespace Api\Admin;

use Core\Api;
use Core\Database;
use Core\Request;
use Core\Response;
use Entity\Account;
use Entity\Permission;
use Provider\AccountProvider;
use Provider\PermissionProvider;
use Provider\RoleProvider;

class AccountApi extends Api {
  public static function mapUrl() {
    return '/api/admin/account';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    $accounts = [];
    foreach (AccountProvider::find() as $account) {
      $data = $account->getData();
      unset($data['password']);
      $accounts[] = $data;
    }
    Response::getInstance()->sendJson($accounts);
  }

  private static function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public static function post() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasData('username', 'email', 'fullName', 'birthday', 'gender', 'phone', 'address')) {
      Response::getInstance()->sendStatus(400);
    }

    $accounts = AccountProvider::find([
      'username' => Request::getInstance()->getData('username')
    ]);
    if (count($accounts) != 0) {
      Response::getInstance()->sendStatus(406);
    }

    $randomPassword = AccountApi::generateRandomString();

    Database::getInstance()->doTransaction(function ($randomPassword) {
      AccountProvider::create(new Account([
        'username' => Request::getInstance()->getData('username'),
        'password' => password_hash($randomPassword, PASSWORD_BCRYPT),
        'fullName' => Request::getInstance()->getData('fullName'),
        'birthday' => Request::getInstance()->getData('birthday'),
        'gender' => Request::getInstance()->getData('gender'),
        'email' => Request::getInstance()->getData('email'),
        'address' => Request::getInstance()->getData('address'),
        'phone' => Request::getInstance()->getData('phone'),
      ]));

      PermissionProvider::create(new Permission([
        'idAccount' => Database::getInstance()->getLastInsertedId(),
        'idRole' => RoleProvider::USER_ID
      ]));
    }, $randomPassword);

    Response::getInstance()->sendJson([
      'password' => $randomPassword
    ]);
  }
};
