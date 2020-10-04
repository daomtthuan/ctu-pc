<?php

namespace Controllers\Apis;

use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Role implements IGetableController {
  public static function mapUrl() {
    return '/api/Role';
  }

  public static function get(Request $request, Response $response) {
    $Role = Database::select('Role', $request->getParam());

    $response->sendJson($Role);
  }
};
