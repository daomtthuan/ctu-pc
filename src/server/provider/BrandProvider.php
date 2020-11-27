<?php

namespace Provider;

use Core\Database;
use Entity\Brand;

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
   * @return int Id brand
   */
  public static function create(Brand $Brand) {
    $data = $Brand->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Brand', $data);
  }

  /**
   * Edit Brand
   * 
   * @param Brand $Brand Edited Brand
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Brand $Brand) {
    $data = $Brand->jsonSerialize();
    unset($data['id']);
    return Database::getInstance()->edit('Brand', $Brand->getId(), $data);
  }

  /**
   * Remove Brand by filter
   * 
   * @param array|null $filter Removing filter
   * 
   * @return int Number removed Brand
   */
  public static function remove(array $filter = null) {
    return Database::getInstance()->remove('Brand', $filter);
  }
}
