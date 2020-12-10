<?php

namespace Api;

use Core\Api;
use Core\Database;
use Core\Request;
use Core\Response;
use Provider\ReviewProvider;

/** Review api */
class ReviewApi extends Api {
  public static function mapUrl() {
    return '/api/review';
  }

  public static function get() {
    if (Request::getInstance()->hasParam('idProduct')) {
      if (!Request::getInstance()->hasParam('start')) {
        $sumStar = 0;
        $reviews = ReviewProvider::find([
          'idProduct' => Request::getInstance()->getParam('idProduct'),
          'state' => 1
        ]);
        foreach ($reviews as $review) {
          $sumStar += $review->getStar();
        }
        Response::getInstance()->sendJson([
          'star' => round($sumStar / count($reviews))
        ]);
      } else {
        $reviews = [];
        foreach (ReviewProvider::find(
          [
            'idProduct' => Request::getInstance()->getParam('idProduct'),
            'state' => 1
          ],
          Request::getInstance()->getParam('start'),
          12,
          ['star'],
          Database::ORDER_DESC
        ) as $review) {
          $data = $review->jsonSerialize();
          $data['writer'] = $review->getWriterAccount()->getFullName();
          $reviews[] = $data;
        }
        Response::getInstance()->sendJson($reviews);
      }
    } else {
      $reviews = [];
      foreach (ReviewProvider::find(['state' => 1], 0, 12, ['star'], Database::ORDER_DESC) as $review) {
        $data = $review->jsonSerialize();
        $data['writer'] = $review->getWriterAccount()->getFullName();
        $reviews[] = $data;
      }
      Response::getInstance()->sendJson($reviews);
    }
  }
};
