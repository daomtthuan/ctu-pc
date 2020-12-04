<?php

namespace Api\Admin;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\ReviewProvider;
use Entity\Review;

/** Admin Review api */
class ReviewApi extends Api {
  public static function mapUrl() {
    return '/api/admin/review';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    $reviews = [];
    foreach (ReviewProvider::find(Request::getInstance()->getParam()) as $review) {
      $data = $review->jsonSerialize();
      $data['writer'] = $review->getWriterAccount()->jsonSerialize();
      unset($data['writer']['password']);
      $events[] = $data;
    }
    Response::getInstance()->sendJson($reviews);
  }

  public static function post() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasData('star', 'idAccount', 'idProduct')) {
      Response::getInstance()->sendStatus(400);
    }

    $success = ReviewProvider::create(new Review([
      'id' => null,
      'star' => Request::getInstance()->getData('star'),
      'idAccount' => Request::getInstance()->getData('idAccount'),
      'idProduct' => Request::getInstance()->getData('idProduct'),
      'state' => null
    ]));

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }

  public static function put() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id') || !Request::getInstance()->hasData('state')) {
      Response::getInstance()->sendStatus(400);
    }

    $reviews = ReviewProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($reviews) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $reviews[0]->setState(Request::getInstance()->getData('state'));

    ReviewProvider::edit($reviews[0]);
    Response::getInstance()->sendStatus(200);
  }

  public static function delete() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendStatus(400);
    }

    $reviews = ReviewProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($reviews) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $success = ReviewProvider::remove($reviews[0]->getId());

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
