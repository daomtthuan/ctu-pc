<?php

namespace Api\User;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\BillProvider;
use Provider\ProductCartProvider;

/** Product cart api */
class ProductCartApi extends Api {
  public static function mapUrl() {
    return '/api/user/product-cart';
  }

  public static function get() {
    $account = Request::getInstance()->verifyAccount();

    if (!Request::getInstance()->hasParam('idBill')) {
      Response::getInstance()->sendStatus(400);
    }

    $bills = BillProvider::find([
      'id' => Request::getInstance()->getParam('idBill'),
      'idAccount' => $account->getId(),
      'state' => 1
    ]);
    if (count($bills) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    Response::getInstance()->sendJson(ProductCartProvider::findInBill(
      Request::getInstance()->getParam('idBill'),
      ['state' => 1]
    ));
  }
};
