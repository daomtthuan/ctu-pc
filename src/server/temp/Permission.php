<?php

namespace Api\Data;

use Core\Bases\Api;
use Core\Bases\IGetableApi;
use Core\Database;
use Core\Request;
use Core\Response;

class Permission extends Api implements IGetableApi {
  public static function mapUrl() {
    return '/api/data/permission';
  }

  public static function get() {
    $Permission = Database::getInstance()->select('Permission', Request::getInstance()->getParam());

    Response::getInstance()->sendJson($Permission);
  }
};
