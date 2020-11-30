<?php

namespace Api;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\CategoryGroupProvider;
use Entity\CategoryGroup;

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

  public static function post() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasData('name')) {
      Response::getInstance()->sendStatus(400);
    }

    $success = CategoryGroupProvider::create(new CategoryGroup([
      'id' => null,
      'name' => Request::getInstance()->getData('name'),
      'state' => null
    ]));

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }

  public static function put() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id') || !Request::getInstance()->hasData('name', 'state')) {
      Response::getInstance()->sendStatus(400);
    }

    $CategoryGroups = CategoryGroupProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($CategoryGroups) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $CategoryGroups[0]->setName(Request::getInstance()->getData('name'));
    $CategoryGroups[0]->setState(Request::getInstance()->getData('state'));

    CategoryGroupProvider::edit($CategoryGroups[0]);
    Response::getInstance()->sendStatus(200);
  }

  public static function delete() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendStatus(400);
    }

    $CategoryGroups = CategoryGroupProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($CategoryGroups) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $success = CategoryGroupProvider::remove($CategoryGroups[0]->getId());

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
