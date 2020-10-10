<?php

namespace Controllers\Auth;

use Core\Bases\Controller;
use Core\Bases\IDeletableController;
use Core\Bases\IGetableController;
use Core\Bases\IPostableController;
use Core\Request;
use Core\Response;

class Local extends Controller implements IGetableController, IPostableController, IDeletableController {
  public static function mapUrl() {
    return '/auth/local';
  }

  public static function get() {
  }

  public static function post() {
    print_r(Request::getInstance()->getData());
    Response::getInstance()->sendStatus(403);
  }

  public static function delete() {
  }
};
