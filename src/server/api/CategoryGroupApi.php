<?php

namespace Api;

use Core\Api;
use Core\Response;
use Provider\CategoryGroupProvider;

/** CategoryGroup api */
class CategoryGroupApi extends Api {
  public static function mapUrl() {
    return '/api/category-group';
  }

  public static function get() {
    Response::getInstance()->sendJson(CategoryGroupProvider::find([
      'state' => 1
    ]));
  }
};
