<?php

namespace Api\Admin\Report;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\ReviewProvider;

/** Review report api */
class ReviewApi extends Api {
  public static function mapUrl() {
    return '/api/admin/report/review';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    if (Request::getInstance()->hasParam('numberFiveStarReviews')) {
      Response::getInstance()->sendJson([
        'count' => ReviewProvider::count(['star' => 5])
      ]);
    }

    Response::getInstance()->sendStatus(400);
  }
};
