<?php

namespace Provider;

use Core\Database;
use Entity\Review;
use Exception;

/** Review provider */
class ReviewProvider {
  /**
   * Find Review by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return Review[] Review
   */
  public static function find(array $filter = null) {
    $Reviews = [];
    foreach (Database::getInstance()->find('Review', $filter) as $data) {
      $Reviews[] = new Review($data);
    }
    return $Reviews;
  }

  /**
   * Create Review
   * 
   * @param Review $Review Created Review
   *
   * @return bool True if success, otherwise false
   */
  public static function create(Review $Review) {
    $data = $Review->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Review', $data) > 0;
  }

  /**
   * Edit Review
   * 
   * @param Review $Review Edited Review
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Review $Review) {
    $data = $Review->jsonSerialize();
    unset($data['id']);
    return Database::getInstance()->edit('Review', $Review->getId(), $data) == 1;
  }

  /**
   * Remove Review
   * 
   * @param int $id Id Review
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(int $id) {
    return Database::getInstance()->doTransaction(function ($id) {
      if (Database::getInstance()->remove('Review', ['id' => $id]) != 1) {
        throw new Exception("Not found Review");
      }
    }, $id);
  }
}
