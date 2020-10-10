<?php

namespace Controllers\Data;

use Core\Bases\Controller;
use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Role extends Controller implements IGetableController {
  public static function mapUrl() {
    return '/data/role';
  }

  public static function get() {
    $Role = Database::select('Role', Request::getInstance()->getParam());

    Response::getInstance()->sendJson($Role);
  }
};
