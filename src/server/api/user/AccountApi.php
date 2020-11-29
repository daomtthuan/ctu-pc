<?php

namespace Api\User;

use Core\Api;
use Core\Request;
use Core\Response;
use Entity\Account;
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

    $success =  AccountProvider::create(new Account([
      'id' => null,
      'username' => Request::getInstance()->getData('username'),
      'password' => Request::getInstance()->getData('password'),
      'fullName' => Request::getInstance()->getData('fullName'),
      'birthday' => Request::getInstance()->getData('birthday'),
      'gender' => Request::getInstance()->getData('gender'),
      'email' => Request::getInstance()->getData('email'),
      'address' => Request::getInstance()->getData('address'),
      'phone' => Request::getInstance()->getData('phone'),
      'state' => null
    ]));

    Response::getInstance()->sendStatus($success ? 200 : 500);
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

    $success = AccountProvider::edit($account);

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
