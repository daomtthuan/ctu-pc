<?php

namespace Provider;

use Core\Database;
use Entity\Review;

/** Review provider */
class ReviewProvider {
  /**
   * Find review by filter
   * 
   * @param array|null $filter Finding filter
   * @param int $start Index starting event
   * @param int $limit Limit number of events for finding
   * @param string[] $orderByKeys Order by keys
   * @param string $typeOrder Type order
   * 
   * @return Review[] Reviews
   */
  public static function find(array $filter = null, int $start = null, $limit = null, array $orderByKeys = null, string $typeOrder = Database::ORDER_ASC) {
    $reviews = [];
    foreach (Database::getInstance()->find('Review', $filter,  $start, $limit, $orderByKeys, $typeOrder) as $data) {
      $reviews[] = new Review($data);
    }
    return $reviews;
  }

  /**
   * Create review
   * 
   * @param Review $review Created review
   *
   * @return bool True if success, otherwise false
   */
  public static function create(Review $review) {
    $data = $review->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Review', $data) > 0;
  }

  /**
   * Edit review
   * 
   * @param Review $review Edited review
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Review $review) {
    $data = $review->jsonSerialize();
    unset($data['id']);
    return Database::getInstance()->edit('Review', $review->getId(), $data) == 1;
  }

  /**
   * Remove review
   * 
   * @param Review $review Removed review
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(Review $review) {
    return Database::getInstance()->remove('Review', ['id' => $review->getId()]) == 1;
  }
}
