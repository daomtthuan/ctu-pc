<?php

namespace Api\User;

use Core\Api;
use Core\Request;
use Core\Response;

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
  }
};
