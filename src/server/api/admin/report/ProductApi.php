<?php

namespace Api\Admin\Report;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\ProductProvider;

/** Product report api */
class ProductApi extends Api {
  public static function mapUrl() {
    return '/api/admin/report/product';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    if (Request::getInstance()->hasParam('numberProducts')) {
      Response::getInstance()->sendJson([
        'count' => ProductProvider::count()
      ]);
    }

    Response::getInstance()->sendStatus(400);
  }
};
