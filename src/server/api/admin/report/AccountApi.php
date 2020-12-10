<?php

namespace Api\Admin\Report;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\AccountProvider;
use Provider\RoleProvider;

/** Account report api */
class AccountApi extends Api {
  public static function mapUrl() {
    return '/api/admin/report/account';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    if (Request::getInstance()->hasParam('numberCustomers')) {
      $numberCustomers = count(AccountProvider::findOwnRole(RoleProvider::USER_ID)) - count(AccountProvider::findOwnRole(RoleProvider::ADMIN_ID));
      Response::getInstance()->sendJson([
        'count' => $numberCustomers
      ]);
    }

    Response::getInstance()->sendStatus(400);
  }
};
