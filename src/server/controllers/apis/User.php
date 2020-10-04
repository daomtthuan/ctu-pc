<?php

namespace Controllers\Apis;

use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class User implements IGetableController {
  public static function mapUrl() {
    return '/api/User';
  }

  public static function get(Request $request, Response $response) {
    $User = Database::select('User', $request->getParam());

    $response->sendJson($User);
  }
};
