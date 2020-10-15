<?php

namespace Controllers\Data;

use Core\Bases\Controller;
use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Brand extends Controller implements IGetableController {
  public static function mapUrl() {
    return '/api/data/brand';
  }

  public static function get() {
    $Brand = Database::getInstance()->select('Brand', Request::getInstance()->getParam());

    Response::getInstance()->sendJson($Brand);
  }
};
