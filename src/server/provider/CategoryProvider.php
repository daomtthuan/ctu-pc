<?php

namespace Provider;

use Core\Database;
use Entity\Category;
use Exception;

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
   * Create Category
   * 
   * @param Category $Category Created Category
   *
   * @return bool True if success, otherwise false
   */
  public static function create(Category $Category) {
    $data = $Category->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Category', $data) > 0;
  }

  /**
   * Edit Category
   * 
   * @param Category $Category Edited Category
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Category $Category) {
    $data = $Category->jsonSerialize();
    unset($data['id']);
    return Database::getInstance()->edit('Category', $Category->getId(), $data) == 1;
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
