<?php

namespace Provider;

use Core\Database;
use Entity\Bill;
use Entity\ProductCart;
use Exception;

/** Bill provider */
class BillProvider {
  public const STATUS_PENDING = 0;
  public const STATUS_SHIPPING = 1;
  public const STATUS_PAID = 2;
  public const STATUS_CANCEL = 3;

  /**
   * Count bill by filter
   * 
   * @param array|null $filter Finding filter
   * @param int $start Index starting bill
   * @param int $limit Limit number of bills for finding
   * @param string[] $orderByKeys Order by keys
   * @param string $typeOrder Type order
   * 
   * @return int Number of bills
   */
  public static function count(array $filter = null, int $start = null, $limit = null, array $orderByKeys = null, string $typeOrder = Database::ORDER_ASC) {
    return Database::getInstance()->count('Bill', $filter,  $start, $limit, $orderByKeys, $typeOrder);
  }

  /**
   * Find bill by filter
   * 
   * @param array|null $filter Finding filter
   * 
   * @return Bill[] Bills
   */
  public static function find(array $filter = null) {
    $bills = [];
    foreach (Database::getInstance()->find('Bill', $filter) as $data) {
      $bills[] = new Bill($data);
    }
    return $bills;
  }

  /**
   * Create bill
   * 
   * @param Bill $bill Created bill
   * @param ProductCart[] $productCarts Product cart in bill
   *
   * @return bool True if success, otherwise false
   */
  public static function create(Bill $bill, array $productCarts) {
    return Database::getInstance()->doTransaction(function ($bill, $productCarts) {
      $data = $bill->jsonSerialize();
      unset($data['id'], $data['createDate'], $data['payDate'], $data['status'], $data['state']);
      if ($data['payDate'] == '' || $data['payDate'] == null) {
        unset($data['payDate']);
      }
      $idBill = Database::getInstance()->create('Bill', $data);

      if (count($productCarts) == 0) {
        throw new Exception('Empty cart');
      }

      foreach ($productCarts as $productCart) {
        $productCart->setIdBill($idBill);
        ProductCartProvider::create($productCart);
      }
    }, $bill, $productCarts);
  }

  /**
   * Edit bill
   * 
   * @param Bill $bill Edited bill
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Bill $bill) {
    $data = $bill->jsonSerialize();
    unset($data['id']);
    if ($data['payDate'] == '' || $data['payDate'] == null) {
      unset($data['payDate']);
    }
    Database::getInstance()->edit('Bill', $bill->getId(), $data);
    return true;
  }

  /**
   * Remove bill
   * 
   * @param Bill $bill Removed bill
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(Bill $bill) {
    return Database::getInstance()->remove('Bill', ['id' => $bill->getId()]) == 1;
  }
}
