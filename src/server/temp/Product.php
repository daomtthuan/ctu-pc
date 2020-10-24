<?php

namespace Api\Data;

use Core\Bases\Api;
use Core\Bases\IGetableApi;
use Core\Database;
use Core\Request;
use Core\Response;

class Product extends Api implements IGetableApi {
  public static function mapUrl() {
    return '/api/data/product';
  }

  public static function get() {
    $Product = Database::getInstance()->select('Product', Request::getInstance()->getParam());

    Response::getInstance()->sendJson($Product);
  }
};
