<?php

namespace Api\User;

use Core\Api;
use Core\Database;
use Core\Request;
use Core\Response;
use Entity\Permission;
use Entity\Account;
use Provider\PermissionProvider;
use Provider\RoleProvider;
use Provider\AccountProvider;

class AccountApi extends Api {
  public static function mapUrl() {
    return '/api/user/account';
  }

  public static function get() {
    $account = Request::getInstance()->verifyAccount()->getData();
    unset($account['id'], $account['password'], $account['state']);
    Response::getInstance()->sendJson($account);
  }

  public static function post() {
    if (!Request::getInstance()->hasData('username', 'password', 'email', 'fullName', 'birthday', 'gender', 'phone', 'address')) {
      Response::getInstance()->sendStatus(400);
    }

    $accounts = AccountProvider::find([
      'username' => Request::getInstance()->getData('username')
    ]);
    if (count($accounts) != 0) {
      Response::getInstance()->sendStatus(406);
    }

    Database::getInstance()->doTransaction(function () {
      AccountProvider::create(new Account([
        'username' => Request::getInstance()->getData('username'),
        'password' => password_hash(Request::getInstance()->getData('password'), PASSWORD_DEFAULT),
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
    });

    Response::getInstance()->sendStatus(200);
  }
};
