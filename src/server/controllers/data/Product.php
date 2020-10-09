<?php

namespace Controllers\Data;

use Core\Bases\Controller;
use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Product extends Controller implements IGetableController {
  public static function mapUrl() {
    return '/data/product';
  }

  public static function get(Request $request, Response $response) {
    $Product = Database::select('Product', $request->getParam());

    $response->sendJson($Product);
  }
};
