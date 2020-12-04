<?php

namespace Provider;

use Core\Database;
use Entity\CategoryGroup;

/** CategoryGroup provider */
class CategoryGroupProvider {
  /**
   * Find category group by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return CategoryGroup[] Category groups
   */
  public static function find(array $filter = null) {
    $categoryGroups = [];
    foreach (Database::getInstance()->find('CategoryGroup', $filter) as $data) {
      $categoryGroups[] = new CategoryGroup($data);
    }
    return $categoryGroups;
  }

  /**
   * Create category group
   * 
   * @param CategoryGroup $categoryGroup Created category group
   *
   * @return bool True if success, otherwise false
   */
  public static function create(CategoryGroup $categoryGroup) {
    $data = $categoryGroup->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('CategoryGroup', $data) > 0;
  }

  /**
   * Edit category group
   * 
   * @param CategoryGroup $categoryGroup Edited category group
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(CategoryGroup $categoryGroup) {
    $data = $categoryGroup->jsonSerialize();
    unset($data['id']);
    return Database::getInstance()->edit('CategoryGroup', $categoryGroup->getId(), $data) == 1;
  }

  /**
   * Remove category group
   * 
   * @param CategoryGroup $categoryGroup Removed category group
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(CategoryGroup $categoryGroup) {
    return Database::getInstance()->remove('CategoryGroup', ['id' => $categoryGroup->getId()]) == 1;
  }
}
