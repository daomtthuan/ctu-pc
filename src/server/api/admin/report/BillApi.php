<?php

namespace Api\Admin\Report;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\BillProvider;

/** Bill report api */
class BillApi extends Api {
  public static function mapUrl() {
    return '/api/admin/report/bill';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    if (Request::getInstance()->hasParam('numberBills')) {
      Response::getInstance()->sendJson([
        'count' => BillProvider::count()
      ]);
    }

    Response::getInstance()->sendStatus(400);
  }
};
