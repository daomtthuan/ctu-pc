<?php

namespace Controllers\Data;

use Core\Bases\Controller;
use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Permission extends Controller implements IGetableController {
  public static function mapUrl() {
    return '/api/data/permission';
  }

  public static function get() {
    $Permission = Database::getInstance()->select('Permission', Request::getInstance()->getParam());

    Response::getInstance()->sendJson($Permission);
  }
};
