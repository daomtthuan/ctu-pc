<?php

namespace Controllers\Auth;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\Service;
use Models\RoleModel;
use Models\UserModel;

class LocalAuthController extends Controller {
  public static function mapUrl() {
    return '/api/auth/local';
  }

  public static function get() {
    if (!Request::getInstance()->verifyUser()) {
      Response::getInstance()->sendStatus(401);
    }

    $users = UserModel::find([
      'id' => Service::getInstance()->getSession('user')
    ]);
    if (count($users) != 1) {
      Response::getInstance()->sendStatus(401);
    }

    if (!$users[0]->getState()) {
      Response::getInstance()->sendStatus(406);
    }

    $roles = RoleModel::findOwnedByUser($users[0]->getId(), [
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

    $users = UserModel::find([
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

    $token = Service::getInstance()->startSession();
    Service::getInstance()->setSession('user', $users[0]->getId());

    Response::getInstance()->sendJson(['token' => $token]);
  }

  public static function delete() {
    if (!Request::getInstance()->verifyUser()) {
      Response::getInstance()->sendStatus(401);
    }

    session_destroy();
    Response::getInstance()->sendStatus(200);
  }
};
