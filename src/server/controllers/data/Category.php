<?php

namespace Controllers\Data;

use Core\Bases\Controller;
use Core\Bases\IGetableController;
use Core\Database;
use Core\Request;
use Core\Response;

class Category extends Controller implements IGetableController {
  public static function mapUrl() {
    return '/api/data/category';
  }

  public static function get() {
    $categories = Database::getInstance()->select('Category', Request::getInstance()->getParam());

    Response::getInstance()->sendJson($categories);
  }
};
