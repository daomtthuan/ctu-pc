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
    Database::getInstance()->edit('Bill', $bill->getId(), $data);
    return true;
  }
}
