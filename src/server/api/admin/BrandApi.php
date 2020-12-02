<?php

namespace Api\Admin;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\BrandProvider;
use Entity\Brand;

/** Admin brand api */
class BrandApi extends Api {
  public static function mapUrl() {
    return '/api/admin/brand';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    Response::getInstance()->sendJson(BrandProvider::find(Request::getInstance()->getParam()));
  }

  public static function post() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasData('name')) {
      Response::getInstance()->sendStatus(400);
    }

    $success = BrandProvider::create(new Brand([
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

    $brands = BrandProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($brands) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $brands[0]->setName(Request::getInstance()->getData('name'));
    $brands[0]->setState(Request::getInstance()->getData('state'));

    BrandProvider::edit($brands[0]);
    Response::getInstance()->sendStatus(200);
  }

  public static function delete() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendStatus(400);
    }

    $brands = BrandProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($brands) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $success = BrandProvider::remove($brands[0]);

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
