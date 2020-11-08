<?php

namespace Api\Admin;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\AccountProvider;

class AccountApi extends Api {
  public static function mapUrl() {
    return '/api/admin/account';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    $accounts = [];
    foreach (AccountProvider::find() as $account) {
      $data = $account->getData();
      unset($data['password']);
      $accounts[] = $data;
    }
    Response::getInstance()->sendJson($accounts);
  }
};
