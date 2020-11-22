<?php

namespace Entity;

use Core\Entity;

class Review extends Entity {
  private int $star;
  private int $idAccount;
  private int $idProduct;

  /** 
   * Create new instance of Review
   * 
   * @param array $data Data Review
   */
  public function __construct(array $data) {
    parent::__construct($data);
    $this->star = (int)$data['star'];
    $this->idAccount = (int)$data['idAccount'];
    $this->idProduct = (int)$data['idProduct'];
  }

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'star' => $this->getStar(),
      'idAccount' => $this->getidAccount(),
      'idProduct' => $this->getIdProduct(),
      'state' => $this->getState()
    ];
  }

  /**
   * Get the value of star
   * 
   * @return int Star
   */
  public function getStar() {
    return $this->star;
  }

  /**
   * Set the value of star
   * 
   * @param int star
   */
  public function setStar(int $star) {
    $this->star = $star;
  }

  /**
   * Get the value of idAccount
   * 
   * @return int IdAccount
   */
  public function getIdAccount() {
    return $this->idAccount;
  }

  /**
   * Set the value of idAccount
   * 
   * @param int id account
   */
  public function setIdAccount(int $idAccount) {
    $this->idAccount = $idAccount;
  }

  /**
   * Get the value of idProduct
   * 
   * @return int IdProduct
   */
  public function getIdProduct() {
    return $this->idProduct;
  }

  /**
   * Set the value of idProduct
   * 
   * @param int id product
   */
  public function setIdProduct(int $idProduct) {
    $this->idProduct = $idProduct;
  }
}
