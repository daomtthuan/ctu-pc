<?php

namespace Api\Admin;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\CategoryProvider;
use Entity\Category;

/** Category api */
class CategoryApi extends Api {
  public static function mapUrl() {
    return '/api/admin/category';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    Response::getInstance()->sendJson(CategoryProvider::find(Request::getInstance()->getParam()));
  }

  public static function post() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasData('name', 'idCategoryGroup')) {
      Response::getInstance()->sendStatus(400);
    }

    $success = CategoryProvider::create(new Category([
      'id' => null,
      'name' => Request::getInstance()->getData('name'),
      'idCategoryGroup' => Request::getInstance()->getData('idCategoryGroup'),
      'state' => null
    ]));

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }

  public static function put() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id') || !Request::getInstance()->hasData('name', 'idCategoryGroup', 'state')) {
      Response::getInstance()->sendStatus(400);
    }

    $Categorys = CategoryProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($Categorys) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $Categorys[0]->setName(Request::getInstance()->getData('name'));
    $Categorys[0]->setIdCategoryGroup(Request::getInstance()->getData('idCategoryGroup'));
    $Categorys[0]->setState(Request::getInstance()->getData('state'));

    CategoryProvider::edit($Categorys[0]);
    Response::getInstance()->sendStatus(200);
  }

  public static function delete() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendStatus(400);
    }

    $Categorys = CategoryProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($Categorys) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $success = CategoryProvider::remove($Categorys[0]);

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
