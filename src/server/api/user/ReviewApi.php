<?php

namespace Api\User;

use Core\Api;
use Core\Request;
use Core\Response;
use Entity\Review;
use Provider\ReviewProvider;

/** Review api */
class ReviewApi extends Api {
  public static function mapUrl() {
    return '/api/user/review';
  }

  public static function get() {
    $account = Request::getInstance()->verifyAccount();

    if (!Request::getInstance()->hasParam('idProduct')) {
      Response::getInstance()->sendStatus(400);
    }

    if (Request::getInstance()->hasParam('reviewed')) {
      Response::getInstance()->sendJson([
        'reviewed' => ReviewProvider::count([
          'idAccount' => $account->getId(),
          'idProduct' => Request::getInstance()->getParam('idProduct'),
          'state' => 1
        ]) == 1
      ]);
    }

    Response::getInstance()->sendJson(ReviewProvider::find([
      'idAccount' => $account->getId(),
      'idProduct' => Request::getInstance()->getParam('idProduct'),
      'state' => 1
    ]));
  }

  public static function post() {
    $account = Request::getInstance()->verifyAccount();

    if (!Request::getInstance()->hasParam('idProduct') || !Request::getInstance()->hasData('star')) {
      Response::getInstance()->sendStatus(400);
    }

    $success = ReviewProvider::create(new Review([
      'id' => null,
      'star' => Request::getInstance()->getData('star'),
      'idAccount' => $account->getId(),
      'idProduct' => Request::getInstance()->getParam('idProduct'),
      'content' => Request::getInstance()->hasData('content') ? Request::getInstance()->getData('content') : null,
      'state' => null
    ]));

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }

  public static function put() {
    $account = Request::getInstance()->verifyAccount();

    if (!Request::getInstance()->hasParam('id') || !Request::getInstance()->hasData('star')) {
      Response::getInstance()->sendStatus(400);
    }

    $reviews = ReviewProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($reviews) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $reviews[0]->setStar(Request::getInstance()->getData('star'));
    $reviews[0]->setContent(Request::getInstance()->getData('content'));

    ReviewProvider::edit($reviews[0]);
    Response::getInstance()->sendStatus(200);
  }
};
