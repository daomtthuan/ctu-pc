<?php

namespace Controllers\User;

use Core\Controller;
use Core\Response;
use Models\CategoryGroupModel;

class CategoryGroup extends Controller {
  public static function mapUrl() {
    return '/api/user/category-group';
  }

  public static function get() {
    $categoryGroups = CategoryGroupModel::find([
      'state' => 1
    ]);

    Response::getInstance()->sendJson($categoryGroups);
  }
};
