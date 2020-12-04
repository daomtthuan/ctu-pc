<?php

namespace Api;

use Core\Api;
use Core\Database;
use Core\Response;
use Provider\ReviewProvider;

/** Review api */
class ReviewApi extends Api {
  public static function mapUrl() {
    return '/api/review';
  }

  public static function get() {
    $reviews = [];
    foreach (ReviewProvider::find(['state' => 1], 0, 12, ['star'], Database::ORDER_DESC) as $review) {
      $data = $review->jsonSerialize();
      $data['writer'] = $review->getWriterAccount()->getFullName();
      $reviews[] = $data;
    }
    Response::getInstance()->sendJson($reviews);
  }
};
