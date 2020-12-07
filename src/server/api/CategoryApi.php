<?php

namespace Api;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\CategoryProvider;

/** Category api */
class CategoryApi extends Api {
  public static function mapUrl() {
    return '/api/category';
  }

  public static function get() {
    if (Request::getInstance()->hasParam('idCategoryGroup')) {
      Response::getInstance()->sendJson(CategoryProvider::find([
        'idCategoryGroup' => Request::getInstance()->getParam('idCategoryGroup'),
        'state' => 1
      ]));
    }

    if (Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendJson(CategoryProvider::find([
        'id' => Request::getInstance()->getParam('id'),
        'state' => 1
      ]));
    }

    Response::getInstance()->sendStatus(400);
  }
};
