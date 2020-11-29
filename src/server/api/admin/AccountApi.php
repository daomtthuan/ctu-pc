<?php

namespace Api\Admin;

use Core\Api;
use Core\Request;
use Core\Response;
use Entity\Account;
use Plugin\StringPlugin;
use Provider\AccountProvider;

/** Admin account api */
class AccountApi extends Api {
  public static function mapUrl() {
    return '/api/admin/account';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    $accounts = [];
    foreach (AccountProvider::find(Request::getInstance()->getParam()) as $account) {
      $data = $account->jsonSerialize();
      unset($data['password']);
      $accounts[] = $data;
    }
    Response::getInstance()->sendJson($accounts);
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

    $success = AccountProvider::create(new Account([
      'id' => null,
      'username' => Request::getInstance()->getData('username'),
      'password' => StringPlugin::generateRandomString(10),
      'fullName' => Request::getInstance()->getData('fullName'),
      'birthday' => Request::getInstance()->getData('birthday'),
      'gender' => Request::getInstance()->getData('gender'),
      'email' => Request::getInstance()->getData('email'),
      'address' => Request::getInstance()->getData('address'),
      'phone' => Request::getInstance()->getData('phone'),
      'state' => null
    ]), true);

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }

  public static function put() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id') || !Request::getInstance()->hasData('email', 'fullName', 'birthday', 'gender', 'phone', 'address', 'state')) {
      Response::getInstance()->sendStatus(400);
    }

    $accounts = AccountProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($accounts) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $accounts[0]->setEmail(Request::getInstance()->getData('email'));
    $accounts[0]->setFullName(Request::getInstance()->getData('fullName'));
    $accounts[0]->setBirthday(Request::getInstance()->getData('birthday'));
    $accounts[0]->setGender(Request::getInstance()->getData('gender'));
    $accounts[0]->setPhone(Request::getInstance()->getData('phone'));
    $accounts[0]->setAddress(Request::getInstance()->getData('address'));
    $accounts[0]->setState(Request::getInstance()->getData('state'));

    AccountProvider::edit($accounts[0]);
    Response::getInstance()->sendStatus(200);
  }

  public static function delete() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendStatus(400);
    }

    $success = AccountProvider::remove(Request::getInstance()->getParam('id'));

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
