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

  public static function get(Request $request, Response $response) {
    $Role = Database::select('Role', $request->getParam());

    $response->sendJson($Role);
  }
};
