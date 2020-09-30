<?php

namespace Models;

class Product {
  private int $id;
  private string $name;
  private float $price;
  private int $quantity;
  private int $idCategory;
  private int $idBrand;
  private bool $state;

  /**
   * Get the value of id
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Get the value of name
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Get the value of price
   */
  public function getPrice() {
    return $this->price;
  }

  /**
   * Get the value of quantity
   */
  public function getQuantity() {
    return $this->quantity;
  }

  /**
   * Get the value of idCategory
   */
  public function getIdCategory() {
    return $this->idCategory;
  }

  /**
   * Get the value of idBrand
   */
  public function getIdBrand() {
    return $this->idBrand;
  }

  /**
   * Get the value of state
   */
  public function getState() {
    return $this->state;
  }
}
