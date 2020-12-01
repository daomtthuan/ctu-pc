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
   * @param Brand $brand Removed brand
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(Brand $brand) {
    return Database::getInstance()->remove('Brand', ['id' => $brand->getId()]) == 1;
  }
}
