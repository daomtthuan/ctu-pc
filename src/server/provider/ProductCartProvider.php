<?php

namespace Provider;

use Core\Database;
use Entity\ProductCart;

/** Product cart provider */
class ProductCartProvider {
  /**
   * Find product cart by filter
   * 
   * @param array|null $filter Finding filter
   * @param int $start Index starting event
   * @param int $limit Limit number of events for finding
   * @param string[] $orderByKeys Order by keys
   * @param string $typeOrder Type order
   * 
   * @return ProductCart[] Products cart
   */
  public static function find(array $filter = null, int $start = null, $limit = null, array $orderByKeys = null, string $typeOrder = Database::ORDER_ASC) {
    $productCarts = [];
    foreach (Database::getInstance()->find('ProductCart', $filter,  $start, $limit, $orderByKeys, $typeOrder) as $data) {
      $productCarts[] = new ProductCart($data);
    }
    return $productCarts;
  }

  /**
   * Find product cart by filter
   * 
   * @param int $idBill Id bill
   * @param array|null $filter Finding filter
   * 
   * @return ProductCart[] Products cart
   */
  public static function findInBill(int $idBill, array $filter = null) {
    $productCartReferenceFilters = Database::getInstance()->createReferenceFilters('ProductCart', $filter);
    $billReferenceFilters = [
      Database::getInstance()->createReferenceFilter('Bill', 'id', $idBill)
    ];

    $result = Database::getInstance()->findJoin('ProductCart', [
      Database::getInstance()->createReference('Bill', 'ProductCart', 'idBill', 'Bill', 'id', Database::JOIN_INNER)
    ], array_merge($billReferenceFilters, $productCartReferenceFilters));

    $productCarts = [];
    foreach ($result as $data) {
      $productCarts[] = new ProductCart($data);
    }
    return $productCarts;
  }

  /**
   * Create product cart
   * 
   * @param ProductCart $cart Created product cart
   *
   * @return bool True if success, otherwise false
   */
  public static function create(ProductCart $productCart) {
    $data = $productCart->jsonSerialize();
    unset($data['id'], $data['state']);
    return Database::getInstance()->create('ProductCart', $data) > 0;
  }
}
