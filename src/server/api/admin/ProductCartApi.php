<?php

namespace Api\Admin;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\BillProvider;
use Provider\ProductCartProvider;

/** Product cart api */
class ProductCartApi extends Api {
  public static function mapUrl() {
    return '/api/admin/product-cart';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    Response::getInstance()->sendJson(ProductCartProvider::find(Request::getInstance()->getParam()));
  }
};
