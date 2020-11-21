<?php

namespace Entity;

use Core\Entity;

class Product extends Entity {
  private int $name;
  private float $price;
  private int $quantity;
  private int $idCategory;
  private int $idBrand;

  /** 
   * Create new instance of Product
   * 
   * @param array $data Data Product
   */
  public function __construct(array $data) {
    parent::__construct($data);
    $this->name = (int)$data['name'];
    $this->price = (float)$data['price'];
    $this->quantity = (int)$data['quantity'];
    $this->idCategory = (int)$data['idCategory'];
    $this->idBrand = (int)$data['idBrand'];
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
   * Get the value of name
   * 
   * @return string Name
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Get the value of price
   * 
   * @return float Price
   */
  public function getPrice() {
    return $this->price;
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
   * Get the value of idCategory
   * 
   * @return int Idcategory
   */
  public function getIdCategory() {
    return $this->idCategory;
  }

  /**
   * Get the value of idBrand
   * 
   * @return int IdBrand
   */
  public function getIdBrand() {
    return $this->idBrand;
  }
}
