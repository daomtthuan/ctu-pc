<?php

namespace Controllers\Data;

use Core\Bases\Controller;
use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class User extends Controller implements IGetableController {
  public static function mapUrl() {
    return '/data/user';
  }

  public static function get() {
    $User = Database::select('User', Request::getInstance()->getParam());

    Response::getInstance()->sendJson($User);
  }
};
