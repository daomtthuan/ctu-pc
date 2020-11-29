<?php

namespace Provider;

use Core\Database;
use Entity\CategoryGroup;
use Exception;

/** CategoryGroup provider */
class CategoryGroupProvider {
  /**
   * Find category group by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return CategoryGroup[] CategoryGroups
   */
  public static function find(array $filter = null) {
    $categoryGroups = [];
    foreach (Database::getInstance()->find('CategoryGroup', $filter) as $data) {
      $categoryGroups[] = new CategoryGroup($data);
    }
    return $categoryGroups;
  }

  /**
   * Create CategoryGroup
   * 
   * @param CategoryGroup $CategoryGroup Created CategoryGroup
   *
   * @return bool True if success, otherwise false
   */
  public static function create(CategoryGroup $CategoryGroup) {
    $data = $CategoryGroup->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('CategoryGroup', $data) > 0;
  }

  /**
   * Edit CategoryGroup
   * 
   * @param CategoryGroup $CategoryGroup Edited CategoryGroup
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(CategoryGroup $CategoryGroup) {
    $data = $CategoryGroup->jsonSerialize();
    unset($data['id']);
    return Database::getInstance()->edit('CategoryGroup', $CategoryGroup->getId(), $data) == 1;
  }

  /**
   * Remove CategoryGroup
   * 
   * @param int $id Id CategoryGroup
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(int $id) {
    return Database::getInstance()->doTransaction(function ($id) {
      $referenceFilters = [
        Database::getInstance()->createReferenceFilter('CategoryGroup', 'id', $id)
      ];
      Database::getInstance()->removeInJoin('Product', 'idCategory', true, [
        Database::getInstance()->createReference('Category', 'Category', 'id', 'Product', 'idCategory', Database::JOIN_INNER),
        Database::getInstance()->createReference('CategoryGroup', 'CategoryGroup', 'id', 'Category', 'idCategoryGroup', Database::JOIN_INNER),
      ], $referenceFilters);

      Database::getInstance()->remove('Category', ['idCategoryGroup' => $id]);
      if (Database::getInstance()->remove('CategoryGroup', ['id' => $id]) != 1) {
        throw new Exception("Not found CategoryGroup");
      }
    }, $id);
  }
}
