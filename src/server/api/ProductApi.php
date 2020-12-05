<?php

namespace Api;

use Core\Api;
use Core\Database;
use Core\Response;
use Provider\ProductProvider;

/** Product api */
class ProductApi extends Api {
  public static function mapUrl() {
    return '/api/product';
  }

  public static function get() {
    Response::getInstance()->sendJson(ProductProvider::find(['state' => 1], 0, 12, ['id'], Database::ORDER_DESC));
  }
};
