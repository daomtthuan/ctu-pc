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

  public static function get(Request $request, Response $response) {
    $User = Database::select('User', $request->getParam());

    $response->sendJson($User);
  }
};
