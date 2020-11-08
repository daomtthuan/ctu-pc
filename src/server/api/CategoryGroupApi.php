<?php

namespace Api;

use Core\Api;
use Core\Response;
use Provider\CategoryGroupProvider;

class CategoryGroupApi extends Api {
  public static function mapUrl() {
    return '/api/category-group';
  }

  public static function get() {
    $categoryGroups = CategoryGroupProvider::find([
      'state' => 1
    ]);

    Response::getInstance()->sendJson($categoryGroups);
  }
};
