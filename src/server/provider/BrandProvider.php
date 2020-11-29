<?php

namespace Provider;

use Core\Database;
use Entity\Brand;
use Exception;

/** Brand provider */
class BrandProvider {
  /**
   * Find Brand by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return Brand[] Brand
   */
  public static function find(array $filter = null) {
    $brands = [];
    foreach (Database::getInstance()->find('Brand', $filter) as $data) {
      $brands[] = new Brand($data);
    }
    return $brands;
  }

  /**
   * Create Brand
   * 
   * @param Brand $brand Created Brand
   *
   * @return bool True if success, otherwise false
   */
  public static function create(Brand $Brand) {
    $data = $Brand->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Brand', $data) > 0;
  }

  /**
   * Edit brand
   * 
   * @param Brand $Brand Edited Brand
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Brand $Brand) {
    $data = $Brand->jsonSerialize();
    unset($data['id']);
    return Database::getInstance()->edit('Brand', $Brand->getId(), $data) == 1;
  }

  /**
   * Remove brand
   * 
   * @param int $id Id brand
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(int $id) {
    return Database::getInstance()->doTransaction(function ($id) {
      $referenceFilters = [
        Database::getInstance()->createReferenceFilter('Brand', 'id', $id)
      ];
      Database::getInstance()->removeInJoin('Review', 'idProduct', true, [
        Database::getInstance()->createReference('Product', 'Product', 'id', 'Review', 'idProduct', Database::JOIN_INNER),
        Database::getInstance()->createReference('Brand', 'Brand', 'id', 'Product', 'idBrand', Database::JOIN_INNER),
      ], $referenceFilters);

      Database::getInstance()->remove('Product', ['idBrand' => $id]);
      if (Database::getInstance()->remove('Brand', ['id' => $id]) != 1) {
        throw new Exception("Not found brand");
      }
    }, $id);
  }
}
