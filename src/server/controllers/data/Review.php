<?php

namespace Controllers\Data;

use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Review implements IGetableController {
  public static function mapUrl() {
    return '/data/review';
  }

  public static function get(Request $request, Response $response) {
    $Review = Database::select('Review', $request->getParam());

    $response->sendJson($Review);
  }
};
