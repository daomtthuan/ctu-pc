<?php

namespace Controllers\Apis;

use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Category implements IGetableController {
  public static function mapUrl() {
    return '/api/category';
  }

  public static function get(Request $request, Response $response) {
    $categories = Database::select('Category', $request->getParam());

    $response->sendJson($categories);
  }
};
