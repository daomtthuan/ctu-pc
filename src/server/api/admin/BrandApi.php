<?php

namespace Api\Admin;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\BrandProvider;
use Core\Database;
use Entity\Brand;

/** Admin brand api */
class BrandApi extends Api {
  public static function mapUrl() {
    return '/api/admin/brand';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    $brands = [];
    foreach (BrandProvider::find(Request::getInstance()->getParam()) as $brand) {
      $data = $brand->jsonSerialize();
      $brands[] = $data;
    }
    Response::getInstance()->sendJson($brands);
  }

  public static function post() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasData('name')) {
      Response::getInstance()->sendStatus(400);
    }

    BrandProvider::create(new Brand([
      'id' => null,
      'username' => Request::getInstance()->getData('name'),
      'state' => null
    ]));

    Response::getInstance()->sendStatus(200);
  }

  public static function put() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id') || !Request::getInstance()->hasData('name')) {
      Response::getInstance()->sendStatus(400);
    }

    $brands = BrandProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($brands) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $brands[0]->setname(Request::getInstance()->getData('name'));

    BrandProvider::edit($brands[0]);
    Response::getInstance()->sendStatus(200);
  }

  public static function delete() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendStatus(400);
    }

    $success = Database::getInstance()->doTransaction(function () {
      $id = Request::getInstance()->getParam('id');

      // TODO: Remove product of brand

    });

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
