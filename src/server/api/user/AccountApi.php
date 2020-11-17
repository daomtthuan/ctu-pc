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

/** User account api */
class AccountApi extends Api {
  public static function mapUrl() {
    return '/api/user/account';
  }

  public static function get() {
    $account = Request::getInstance()->verifyAccount()->jsonSerialize();
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
      $idAccount = AccountProvider::create(new Account([
        'username' => Request::getInstance()->getData('username'),
        'password' => password_hash(Request::getInstance()->getData('password'), PASSWORD_BCRYPT),
        'fullName' => Request::getInstance()->getData('fullName'),
        'birthday' => Request::getInstance()->getData('birthday'),
        'gender' => Request::getInstance()->getData('gender'),
        'email' => Request::getInstance()->getData('email'),
        'address' => Request::getInstance()->getData('address'),
        'phone' => Request::getInstance()->getData('phone'),
      ]));

      PermissionProvider::create(new Permission([
        'idAccount' => $idAccount,
        'idRole' => RoleProvider::USER_ID
      ]));
    });

    Response::getInstance()->sendStatus(200);
  }

  public static function put() {
    $account = Request::getInstance()->verifyAccount();
    if (!Request::getInstance()->hasData('email', 'fullName', 'birthday', 'gender', 'phone', 'address')) {
      Response::getInstance()->sendStatus(400);
    }

    $account->setEmail(Request::getInstance()->getData('email'));
    $account->setFullName(Request::getInstance()->getData('fullName'));
    $account->setBirthday(Request::getInstance()->getData('birthday'));
    $account->setGender(Request::getInstance()->getData('gender'));
    $account->setPhone(Request::getInstance()->getData('phone'));
    $account->setAddress(Request::getInstance()->getData('address'));

    AccountProvider::edit($account);
    Response::getInstance()->sendStatus(200);
  }
};
