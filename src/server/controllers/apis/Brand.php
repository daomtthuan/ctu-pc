<?php

namespace Controllers\Apis;

use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Brand implements IGetableController {
  public static function mapUrl() {
    return '/api/Brand';
  }

  public static function get(Request $request, Response $response) {
    $Brand = Database::select('Brand', $request->getParam());

    $response->sendJson($Brand);
  }
};
