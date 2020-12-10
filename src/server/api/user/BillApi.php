<?php

namespace Api\User;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\BillProvider;

/** Bill api */
class BillApi extends Api {
  public static function mapUrl() {
    return '/api/user/bill';
  }

  public static function get() {
    $account = Request::getInstance()->verifyAccount();

    if (Request::getInstance()->hasParam('id')) {
      $bills = BillProvider::find([
        'idAccount' => $account->getId(),
        'id' => Request::getInstance()->getParam('id'),
        'state' => 1
      ]);
      if (count($bills) != 1) {
        Response::getInstance()->sendStatus(404);
      }

      Response::getInstance()->sendJson($bills);
    }

    if (Request::getInstance()->hasParam('status')) {
      $status = Request::getInstance()->getParam('status');
      if (
        $status != BillProvider::STATUS_PENDING &&
        $status != BillProvider::STATUS_SHIPPING &&
        $status != BillProvider::STATUS_PAID &&
        $status != BillProvider::STATUS_CANCEL
      ) {
        Response::getInstance()->sendStatus(400);
      }

      $bills = [];
      foreach (BillProvider::find([
        'idAccount' => $account->getId(),
        'status' => $status,
        'state' => 1
      ]) as $bill) {
        $data = $bill->jsonSerialize();
        $data['imageUrl'] = $bill->getImageUrl();
        $data['total'] = $bill->getTotal();
        $data['numberProductCarts'] = $bill->getNunberProductCarts();
        $bills[] = $data;
      }
      Response::getInstance()->sendJson($bills);
    }

    Response::getInstance()->sendStatus(400);
  }

  public static function delete() {
    $account = Request::getInstance()->verifyAccount();

    if (Request::getInstance()->hasParam('id')) {
      $bills = BillProvider::find([
        'idAccount' => $account->getId(),
        'id' => Request::getInstance()->getParam('id'),
        'state' => 1
      ]);
      if (count($bills) != 1) {
        Response::getInstance()->sendStatus(404);
      }

      $bills[0]->setStatus(BillProvider::STATUS_CANCEL);
      $success = BillProvider::edit($bills[0]);
      Response::getInstance()->sendStatus($success ? 200 : 500);
    }

    Response::getInstance()->sendStatus(400);
  }
};
