<?php

namespace Controllers\Data;

use Core\Bases\Controller;
use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class CategoryGroup extends Controller implements IGetableController {
  public static function mapUrl() {
    return '/data/category-group';
  }

  public static function get(Request $request, Response $response) {
    $categoryGroups = Database::select('CategoryGroup', $request->getParam());

    $response->sendJson($categoryGroups);
  }
};
