<?php

namespace Entities;

use Core\Entity;

class Product extends Entity {
  /**
   * Create new instance of Permission
   * 
   * @param array $data Data
   */
  public function __construct(array $data) {
    parent::__construct($data);
  }

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'name' => $this->getName(),
      'price' => $this->getPrice(),
      'quantity' => $this->getQuantity(),
      'idCategory' => $this->getIdCategory(),
      'idBrand' => $this->getIdBrand(),
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
   * Get the value of name
   * 
   * @return string Name
   */
  public function getName() {
    return $this->data['name'];
  }

  /**
   * Get the value of price
   * 
   * @return float Price
   */
  public function getPrice() {
    return $this->data['price'];
  }

  /**
   * Get the value of quantity
   * 
   * @return int Quantity
   */
  public function getQuantity() {
    return $this->data['quantity'];
  }

  /**
   * Get the value of idCategory
   * 
   * @return int Idcategory
   */
  public function getIdCategory() {
    return $this->data['idCategory'];
  }

  /**
   * Get the value of idBrand
   * 
   * @return int IdBrand
   */
  public function getIdBrand() {
    return $this->data['idBrand'];
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
