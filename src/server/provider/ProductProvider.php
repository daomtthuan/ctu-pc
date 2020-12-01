<?php

namespace Provider;

use Core\Database;
use Entity\Product;
use Exception;

/** Product provider */
class ProductProvider {
  /**
   * Find Product by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return Product[] Product
   */
  public static function find(array $filter = null) {
    $Products = [];
    foreach (Database::getInstance()->find('Product', $filter) as $data) {
      $Products[] = new Product($data);
    }
    return $Products;
  }

  /**
   * Create Product
   * 
   * @param Product $Product Created Product
   *
   * @return bool True if success, otherwise false
   */
  public static function create(Product $Product) {
    $data = $Product->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Product', $data) > 0;
  }

  /**
   * Edit Product
   * 
   * @param Product $Product Edited Product
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Product $Product) {
    $data = $Product->jsonSerialize();
    unset($data['id']);
    return Database::getInstance()->edit('Product', $Product->getId(), $data) == 1;
  }

  /**
   * Remove Product
   * 
   * @param int $id Id Product
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(int $id) {
    return Database::getInstance()->doTransaction(function ($id) {
      Database::getInstance()->remove('Review', ['idProduct' => $id]);
      if (Database::getInstance()->remove('Product', ['id' => $id]) != 1) {
        throw new Exception("Not found Product");
      }
    }, $id);
  }
}
