<?php

namespace Controllers\Data;

use Core\Bases\Controller;
use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Category extends Controller implements IGetableController {
  public static function mapUrl() {
    return '/data/category';
  }

  public static function get(Request $request, Response $response) {
    $categories = Database::select('Category', $request->getParam());

    $response->sendJson($categories);
  }
};
