<?php

namespace Api\Authentication;

use Core\Api;
use Core\Request;
use Core\Response;
use Core\Session;
use Provider\RoleProvider;
use Provider\UserProvider;

class LocalApi extends Api {
  public static function mapUrl() {
    return '/api/authentication/local';
  }

  public static function get() {
    $user = Request::getInstance()->verifyUser();

    $roles = RoleProvider::findOwnedByUser($user, [
      'state' => 1
    ]);
    if (count($roles) == 0) {
      Response::getInstance()->sendStatus(406);
    }
    $scopes = [];
    foreach ($roles as $role) {
      $scopes[] = $role->getName();
    }

    Response::getInstance()->sendJson([
      'user' => [
        'scope' => $scopes
      ]
    ]);
  }

  public static function post() {
    if (!Request::getInstance()->hasData('username', 'password')) {
      Response::getInstance()->sendStatus(400);
    }

    $users = UserProvider::find([
      'username' => Request::getInstance()->getData('username')
    ]);
    if (count($users) != 1) {
      Response::getInstance()->sendStatus(401);
    }

    if (!password_verify(Request::getInstance()->getData('password'), $users[0]->getPassword())) {
      Response::getInstance()->sendStatus(401);
    }

    if (!$users[0]->getState()) {
      Response::getInstance()->sendStatus(406);
    }

    $token = Session::start();
    Session::set('user', $users[0]->getId());

    Response::getInstance()->sendJson(['token' => $token]);
  }

  public static function delete() {
    Request::getInstance()->verifyUser();
    Session::stop();
    Response::getInstance()->sendStatus(200);
  }
};
