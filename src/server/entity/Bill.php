<?php

namespace Entity;

use Core\Entity;
use Provider\ProductCartProvider;
use Provider\ProductProvider;

class Bill extends Entity {
  private int $idAccount;
  private string $createDate;
  private string $payDate;
  private int $status;

  /** 
   * Create new instance of Bill
   * 
   * @param array $data Data Bill
   */
  public function __construct(array $data) {
    parent::__construct($data);
    $this->idAccount = (int)$data['idAccount'];
    $this->createDate = (string)$data['createDate'];
    $this->payDate = (string)$data['payDate'];
    $this->status = (int)$data['status'];
  }

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'idAccount' => $this->getIdAccount(),
      'createDate' => $this->getCreateDate(),
      'payDate' => $this->getPayDate(),
      'status' => $this->getStatus(),
      'state' => $this->getState()
    ];
  }

  /**
   * Get the value of id account
   * 
   * @return int Id account
   */
  public function getIdAccount() {
    return $this->idAccount;
  }

  /**
   * Set the value of id account
   * 
   * @param int $idAccount Id account
   */
  public function setIdAccount(int $idAccount) {
    $this->idAccount = $idAccount;
  }

  /**
   * Get the value of created date
   * 
   * @return string Created date
   */
  public function getCreateDate() {
    return $this->createDate;
  }

  /**
   * Set the value of created date
   * 
   * @param string $createDate Created date
   */
  public function setCreateDate(string $createDate) {
    $this->createDate = $createDate;
  }

  /**
   * Get the value of paid date
   * 
   * @return string paid date
   */
  public function getPayDate() {
    return $this->payDate;
  }

  /**
   * Set the value of paid date
   * 
   * @param string $payDate paid date
   */
  public function setPayDate(string $payDate) {
    $this->payDate = $payDate;
  }

  /**
   * Get the value of status
   * 
   * @return int Status
   */
  public function getStatus() {
    return $this->status;
  }

  /**
   * Set the value of status
   * 
   * @param int $status Status
   */
  public function setStatus(int $status) {
    $this->status = $status;
  }

  /**
   * Get the value of image url
   * 
   * @return string Image url
   */
  public function getImageUrl() {
    $idProduct = ProductCartProvider::find(['idBill' => $this->id], 0, 1)[0]->getIdProduct();
    return ProductProvider::find(['id' => $idProduct])[0]->getImage1Url();
  }

  /**
   * Get the value of tatal price
   * 
   * @return float Total price
   */
  public function getTotal() {
    $sum = 0;
    foreach (ProductCartProvider::find(['idBill' => $this->id]) as $productCart) {
      $product = ProductProvider::find(['id' => $productCart->getIdProduct()])[0];
      $sum += ($product->getPrice() * $productCart->getQuantity());
    }
    return $sum;
  }

  /**
   * Get number of product carts
   * 
   * @return int Number of product carts
   */
  public function getNunberProductCarts() {
    $sum = 0;
    foreach (ProductCartProvider::find(['idBill' => $this->id]) as $productCart) {
      $sum += $productCart->getQuantity();
    }
    return $sum;
  }
}
