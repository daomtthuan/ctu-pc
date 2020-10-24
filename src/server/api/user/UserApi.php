<?php

namespace Api\User;

use Core\Api;
use Core\Database;
use Core\Request;
use Core\Response;
use Entity\Permission;
use Entity\User;
use Exception;
use Provider\PermissionProvider;
use Provider\RoleProvider;
use Provider\UserProvider;

class UserApi extends Api {
  public static function mapUrl() {
    return '/api/user/user';
  }

  public static function get() {
  }

  public static function post() {
    if (!Request::getInstance()->hasData('username', 'password', 'email', 'fullName', 'birthday', 'gender', 'phone', 'address')) {
      Response::getInstance()->sendStatus(400);
    }

    $users = UserProvider::find([
      'username' => Request::getInstance()->getData('username')
    ]);
    if (count($users) != 0) {
      Response::getInstance()->sendStatus(406);
    }

    Database::getInstance()->doTransaction(function () {
      UserProvider::add(new User([
        'username' => Request::getInstance()->getData('username'),
        'password' => password_hash(Request::getInstance()->getData('password'), PASSWORD_DEFAULT),
        'fullName' => Request::getInstance()->getData('fullName'),
        'birthday' => Request::getInstance()->getData('birthday'),
        'gender' => Request::getInstance()->getData('gender'),
        'email' => Request::getInstance()->getData('email'),
        'address' => Request::getInstance()->getData('address'),
        'phone' => Request::getInstance()->getData('phone'),
      ]));

      PermissionProvider::add(new Permission([
        'idUser' => Database::getInstance()->getLastInsertedId(),
        'idRole' => RoleProvider::USER_ID
      ]));
    });

    Response::getInstance()->sendStatus(200);
  }
};
