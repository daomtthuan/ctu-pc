<?php

namespace Api\Data;

use Core\Bases\Api;
use Core\Bases\IGetableApi;
use Core\Database;
use Core\Request;
use Core\Response;

class Review extends Api implements IGetableApi {
  public static function mapUrl() {
    return '/api/data/review';
  }

  public static function get() {
    $Review = Database::getInstance()->select('Review', Request::getInstance()->getParam());

    Response::getInstance()->sendJson($Review);
  }
};
