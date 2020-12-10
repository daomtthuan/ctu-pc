<?php

namespace Entity;

use Core\Entity;

class ProductCart extends Entity {
  private int $idBill;
  private int $idProduct;
  private int $quantity;

  /** 
   * Create new instance of Bill
   * 
   * @param array $data Data Bill
   */
  public function __construct(array $data) {
    parent::__construct($data);
    $this->idBill = (int)$data['idBill'];
    $this->idProduct = (int)$data['idProduct'];
    $this->quantity = (int)$data['quantity'];
  }

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'idBill' => $this->getIdBill(),
      'idProduct' => $this->getIdProduct(),
      'quantity' => $this->getQuantity(),
      'state' => $this->getState()
    ];
  }

  /**
   * Get the value of id bill
   * 
   * @return int Id bill
   */
  public function getIdBill() {
    return $this->idBill;
  }

  /**
   * Set the value of id bill
   * 
   * @param int $idBill Id bill
   */
  public function setIdBill(int $idBill) {
    $this->idBill = $idBill;
  }

  /**
   * Get the value of id product
   * 
   * @return int Id product
   */
  public function getIdProduct() {
    return $this->idProduct;
  }

  /**
   * Set the value of id product
   * 
   * @param int $idBill Id product
   */
  public function setIdProduct(int $idProduct) {
    $this->idProduct = $idProduct;
  }

  /**
   * Get the value of quantity
   * 
   * @return int Quantity
   */
  public function getQuantity() {
    return $this->quantity;
  }

  /**
   * Set the value of quantity
   * 
   * @param int $quantity Quantity
   */
  public function setQuantity(int $quantity) {
    $this->quantity = $quantity;
  }
}
