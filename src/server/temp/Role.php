<?php

namespace Api\Data;

use Core\Bases\Api;
use Core\Bases\IGetableApi;
use Core\Database;
use Core\Request;
use Core\Response;

class Role extends Api implements IGetableApi {
  public static function mapUrl() {
    return '/api/data/role';
  }

  public static function get() {
    $Role = Database::getInstance()->select('Role', Request::getInstance()->getParam());

    Response::getInstance()->sendJson($Role);
  }
};
