<?php

namespace Controllers\Apis;

use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Review implements IGetableController {
  public static function mapUrl() {
    return '/api/Review';
  }

  public static function get(Request $request, Response $response) {
    $Review = Database::select('Review', $request->getParam());

    $response->sendJson($Review);
  }
};
