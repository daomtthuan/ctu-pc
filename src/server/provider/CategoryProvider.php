<?php

namespace Provider;

use Core\Database;
use Entity\Category;

class CategoryProvider {
  /**
   * Find by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return Category[] Categories
   */
  public static function find(array $filter = null) {
    $categories = [];
    foreach (Database::getInstance()->find('Category', $filter) as $data) {
      $categories[] = new Category($data);
    }
    return $categories;
  }
}
