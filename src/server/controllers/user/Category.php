<?php

namespace Controllers\User;

use Core\Controller;
use Core\Request;
use Core\Response;
use Models\CategoryModel;

class Category extends Controller {
  public static function mapUrl() {
    return '/api/user/category';
  }

  public static function get() {
    if (!Request::getInstance()->hasParam('idCategoryGroup')) {
      Response::getInstance()->sendStatus(400);
    }

    $categories = CategoryModel::find([
      'idCategoryGroup' => Request::getInstance()->getParam('idCategoryGroup'),
      'state' => 1
    ]);

    Response::getInstance()->sendJson($categories);
  }
};
