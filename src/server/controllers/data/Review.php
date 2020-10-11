<?php

namespace Controllers\Data;

use Core\Bases\Controller;
use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Review extends Controller implements IGetableController {
  public static function mapUrl() {
    return '/api/data/review';
  }

  public static function get() {
    $Review = Database::getInstance()->select('Review', Request::getInstance()->getParam());

    Response::getInstance()->sendJson($Review);
  }
};
