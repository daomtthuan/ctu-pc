<?php

namespace Provider;

use Core\Database;
use Entity\Brand;
use Exception;

/** Brand provider */
class BrandProvider {
  /**
   * Find brand by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return Brand[] Brands
   */
  public static function find(array $filter = null) {
    $brands = [];
    foreach (Database::getInstance()->find('Brand', $filter) as $data) {
      $brands[] = new Brand($data);
    }
    return $brands;
  }

  /**
   * Create brand
   * 
   * @param Brand $brand Created brand
   *
   * @return bool True if success, otherwise false
   */
  public static function create(Brand $brand) {
    $data = $brand->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Brand', $data) > 0;
  }

  /**
   * Edit brand
   * 
   * @param Brand $Brand Edited brand
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Brand $brand) {
    $data = $brand->jsonSerialize();
    unset($data['id']);
    return Database::getInstance()->edit('Brand', $brand->getId(), $data) == 1;
  }

  /**
   * Remove brand
   * 
   * @param Brand $brand Removed brand
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(Brand $brand) {
    return Database::getInstance()->remove('Brand', ['id' => $brand->getId()]) == 1;
  }
}
