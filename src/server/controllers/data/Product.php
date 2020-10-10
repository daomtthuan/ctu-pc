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

  public static function get() {
    $Product = Database::select('Product', Request::getInstance()->getParam());

    Response::getInstance()->sendJson($Product);
  }
};
