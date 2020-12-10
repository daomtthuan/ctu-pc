<?php

namespace Api\User;

use Core\Api;
use Core\Request;
use Core\Response;
use Entity\Bill;
use Entity\ProductCart;
use Provider\BillProvider;

/** Pay api */
class PayApi extends Api {
  public static function mapUrl() {
    return '/api/user/pay';
  }

  public static function post() {
    $account = Request::getInstance()->verifyAccount();

    if (!Request::getInstance()->hasData('cart')) {
      Response::getInstance()->sendStatus(400);
    }

    $cart = Request::getInstance()->getData('cart');

    if (count($cart) == 0) {
      Response::getInstance()->sendStatus(400);
    }

    $productCarts = [];
    foreach ($cart as $productCart) {
      if (isset($productCart['id'], $productCart['quantity'])) {
        $productCarts[] = new ProductCart([
          'id' => null,
          'idBill' => null,
          'idProduct' => $productCart['id'],
          'quantity' => $productCart['quantity'],
          'state' => null,
        ]);
      } else {
        Response::getInstance()->sendStatus(400);
      }
    }

    $success = BillProvider::create(new Bill([
      'id' => null,
      'idAccount' => $account->getId(),
      'createDate' => null,
      'payDate'  => null,
      'status'  => null,
      'state' => null
    ]), $productCarts);

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
