<?php

namespace Controllers\Apis;

use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class CategoryGroup implements IGetableController {
  public static function mapUrl() {
    return '/api/category-group';
  }

  public static function get(Request $request, Response $response) {
    $categoryGroups = Database::select('CategoryGroup', $request->getParam());

    $response->sendJson($categoryGroups);
  }
};
