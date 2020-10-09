<?php

namespace Controllers\Data;

use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Brand implements IGetableController {
  public static function mapUrl() {
    return '/data/brand';
  }

  public static function get(Request $request, Response $response) {
    $Brand = Database::select('Brand', $request->getParam());

    $response->sendJson($Brand);
  }
};
