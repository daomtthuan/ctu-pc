<?php

namespace Api\User;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\CategoryProvider;

class CategoryApi extends Api {
  public static function mapUrl() {
    return '/api/user/category';
  }

  public static function get() {
    if (!Request::getInstance()->hasParam('idCategoryGroup')) {
      Response::getInstance()->sendStatus(400);
    }

    $categories = CategoryProvider::find([
      'idCategoryGroup' => Request::getInstance()->getParam('idCategoryGroup'),
      'state' => 1
    ]);

    Response::getInstance()->sendJson($categories);
  }
};
