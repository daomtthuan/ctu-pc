<?php

namespace Api;

use Core\Api;
use Core\Database;
use Core\Request;
use Core\Response;
use Provider\ProductProvider;

/** Product api */
class ProductApi extends Api {
  public static function mapUrl() {
    return '/api/product';
  }

  public static function get() {
    if (!Request::getInstance()->hasParam()) {
      Response::getInstance()->sendJson(ProductProvider::find(['state' => 1], 0, 12, ['id'], Database::ORDER_DESC));
    }

    if (Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendJson(ProductProvider::find([
        'id' => Request::getInstance()->getParam('id'),
        'state' => 1
      ]));
    }

    if (!Request::getInstance()->hasParam('idCategory')) {
      Response::getInstance()->sendStatus(400);
    }

    if (Request::getInstance()->hasParam('count')) {
      Response::getInstance()->sendJson([
        'count' => ProductProvider::count([
          'idCategory' => Request::getInstance()->getParam('idCategory'),
          'state' => 1
        ])
      ]);
    }

    if (Request::getInstance()->hasParam('start', 'limit')) {
      Response::getInstance()->sendJson(ProductProvider::find(
        ['idCategory' => 1, 'state' => 1],
        Request::getInstance()->getParam('start'),
        Request::getInstance()->getParam('limit'),
        ['id'],
        Database::ORDER_DESC
      ));
    }
  }
};
