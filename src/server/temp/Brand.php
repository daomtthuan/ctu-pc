<?php

namespace Api\Data;

use Core\Bases\Api;
use Core\Bases\IGetableApi;
use Core\Database;
use Core\Request;
use Core\Response;

class Brand extends Api implements IGetableApi {
  public static function mapUrl() {
    return '/api/data/brand';
  }

  public static function get() {
    $Brand = Database::getInstance()->select('Brand', Request::getInstance()->getParam());

    Response::getInstance()->sendJson($Brand);
  }
};
