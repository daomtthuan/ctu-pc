<?php

namespace Controllers\Data;

use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Permission implements IGetableController {
  public static function mapUrl() {
    return '/data/permission';
  }

  public static function get(Request $request, Response $response) {
    $Permission = Database::select('Permission', $request->getParam());

    $response->sendJson($Permission);
  }
};
