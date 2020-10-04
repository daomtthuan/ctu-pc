<?php

namespace Controllers\Apis;

use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Permission implements IGetableController {
  public static function mapUrl() {
    return '/api/Permission';
  }

  public static function get(Request $request, Response $response) {
    $Permission = Database::select('Permission', $request->getParam());

    $response->sendJson($Permission);
  }
};
