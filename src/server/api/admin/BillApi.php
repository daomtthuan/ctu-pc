<?php

namespace Api\Admin;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\BillProvider;

/** Bill api */
class BillApi extends Api {
  public static function mapUrl() {
    return '/api/admin/bill';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    $bills = [];
    foreach (BillProvider::find(Request::getInstance()->getParam()) as $bill) {
      $data = $bill->jsonSerialize();
      $data['customer'] = $bill->getCustomer()->jsonSerialize();
      $data['total'] = $bill->getTotal();
      unset($data['customer']['password']);
      $bills[] = $data;
    }
    Response::getInstance()->sendJson($bills);
  }

  public static function put() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id') || !(Request::getInstance()->hasData('state') || Request::getInstance()->hasData('status'))) {
      Response::getInstance()->sendStatus(400);
    }

    $bills = BillProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($bills) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    if (Request::getInstance()->hasData('state')) {
      $bills[0]->setState(Request::getInstance()->getData('state'));
    }

    if (Request::getInstance()->hasData('status')) {
      $bills[0]->setStatus(Request::getInstance()->getData('status'));
      if ($bills[0]->getStatus() == 2) {
        $bills[0]->setPayDate(date('Y-m-d'));
      }
    }

    BillProvider::edit($bills[0]);
    Response::getInstance()->sendStatus(200);
  }

  public static function delete() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendStatus(400);
    }

    $bills = BillProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($bills) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $success = BillProvider::remove($bills[0]);

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
