<?php

namespace Entity;

use Core\Entity;

class Review extends Entity {
  /**
   * Create new instance of Review
   * 
   * @param array $data Data
   */
  public function __construct(array $data) {
    parent::__construct($data);
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
   * Get the value of id
   * 
   * @return int Id
   */
  public function getId() {
    return $this->data['id'];
  }

  /**
   * Get the value of star
   * 
   * @return int Star
   */
  public function getStar() {
    return $this->data['star'];
  }

  /**
   * Get the value of idAccount
   * 
   * @return int IdAccount
   */
  public function getIdAccount() {
    return $this->data['idAccount'];
  }

  /**
   * Get the value of idProduct
   * 
   * @return int IdProduct
   */
  public function getIdProduct() {
    return $this->data['idProduct'];
  }

  /**
   * Get the value of state
   * 
   * @return int State
   */
  public function getState() {
    return $this->data['state'];
  }
}
