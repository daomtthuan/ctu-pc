<?php

namespace Provider;

use Core\Database;
use Entity\Category;

/** Category provider */
class CategoryProvider {
  /**
   * Find category by filter
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

  /**
   * Create category
   * 
   * @param Category $category Created category
   *
   * @return bool True if success, otherwise false
   */
  public static function create(Category $category) {
    $data = $category->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Category', $data) > 0;
  }

  /**
   * Edit category
   * 
   * @param Category $category Edited category
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Category $category) {
    $data = $category->jsonSerialize();
    unset($data['id']);
    Database::getInstance()->edit('Category', $category->getId(), $data);
    return true;
  }

  /**
   * Remove category
   * 
   * @param Category $category Removed category
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(Category $category) {
    return Database::getInstance()->remove('Category', ['id' => $category->getId()]) == 1;
  }
}
