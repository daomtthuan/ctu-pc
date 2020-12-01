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
   * Set the value of name
   * 
   * @param string Name
   */
  public function setName(string $name) {
    $this->name = $name;
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
   * Set the value of price
   * 
   * @param float price
   */
  public function setPrice(float $price) {
    $this->price = $price;
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
   * @param int quantity
   */
  public function setQuantity(int $quantity) {
    $this->quantity = $quantity;
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
   * Set the value of idCategory
   * 
   * @param int id Category
   */
  public function setIdCategory(int $idCategory) {
    $this->idCategory = $idCategory;
  }

  /**
   * Get the value of idBrand
   * 
   * @return int IdBrand
   */
  public function getIdBrand() {
    return $this->idBrand;
  }

  /**
   * Set the value of idBrand
   * 
   * @param int id Brand
   */
  public function setIdBrand(int $idBrand) {
    $this->idBrand = $idBrand;
  }
}
