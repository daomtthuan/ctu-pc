<?php

namespace Controllers;

use Core\Bases\Controller;
use Core\Bases\IDeletableController;
use Core\Bases\IGetableController;
use Core\Bases\IPostableController;
use Core\Database;
use Core\Request;
use Core\Response;
use Core\Service;

class Auth extends Controller implements IGetableController, IPostableController, IDeletableController {
  public static function mapUrl() {
    return '/api/auth';
  }

  public static function get() {
    if (!Request::getInstance()->hasCookie($_ENV['TOKEN_KEY'])) {
      Response::getInstance()->sendStatus(403);
    }

    Service::getInstance()->startSession(Request::getInstance()->getCookie($_ENV['TOKEN_KEY']));
    if (!Service::getInstance()->hasSession('user')) {
      Response::getInstance()->sendStatus(403);
    }

    $users = Database::getInstance()->select('User', [
      'id' => Service::getInstance()->getSession('user')
    ]);
    Response::getInstance()->sendJson([
      'user' => $users[0]
    ]);
  }

  public static function post() {
    if (!Request::getInstance()->hasData('username', 'password')) {
      Response::getInstance()->sendStatus(400);
    }

    $username = Request::getInstance()->getData('username');
    $password = Request::getInstance()->getData('password');

    /** @var \Models\User[] */
    $users = Database::getInstance()->select('User', [
      'username' => $username
    ]);

    // Not existed
    if (count($users) != 1) {
      Response::getInstance()->sendStatus(403);
    }

    // Invalid password
    if (!password_verify($password, $users[0]->getPassword())) {
      Response::getInstance()->sendStatus(403);
    }

    $token = Service::getInstance()->startSession();
    Service::getInstance()->setSession('user', $users[0]->getId());
    Response::getInstance()->sendJson([
      'token' => $token
    ]);
  }

  public static function delete() {
    if (!Request::getInstance()->hasCookie($_ENV['TOKEN_KEY'])) {
      Response::getInstance()->sendStatus(403);
    }

    Service::getInstance()->startSession(Request::getInstance()->getCookie($_ENV['TOKEN_KEY']));
    if (!Service::getInstance()->hasSession('user')) {
      Response::getInstance()->sendStatus(403);
    }

    session_destroy();
    Response::getInstance()->sendStatus(200);
  }
};
