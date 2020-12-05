<?php

namespace Provider;

use Core\Database;
use Entity\Product;

/** Product provider */
class ProductProvider {
  /**
   * Find product by filter
   * 
   * @param array|null $filter Finding filter
   * @param int $start Index starting event
   * @param int $limit Limit number of events for finding
   * @param string[] $orderByKeys Order by keys
   * @param string $typeOrder Type order
   * 
   * @return Product[] Products
   */
  public static function find(array $filter = null, int $start = null, $limit = null, array $orderByKeys = null, string $typeOrder = Database::ORDER_ASC) {
    $products = [];
    foreach (Database::getInstance()->find('Product', $filter,  $start, $limit, $orderByKeys, $typeOrder) as $data) {
      $products[] = new Product($data);
    }
    return $products;
  }

  /**
   * Create product
   * 
   * @param Product $product Created product
   *
   * @return bool True if success, otherwise false
   */
  public static function create(Product $product) {
    $data = $product->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('Product', $data) > 0;
  }

  /**
   * Edit product
   * 
   * @param Product $product Edited product
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Product $product) {
    $data = $product->jsonSerialize();
    unset($data['id']);
    return Database::getInstance()->edit('Product', $product->getId(), $data) == 1;
  }

  /**
   * Remove product
   * 
   * @param Product $product Removed product
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(Product $product) {
    return Database::getInstance()->remove('Product', ['id' => $product->getId()]) == 1;
  }
}
