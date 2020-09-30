<?php

namespace Models;

class Review {
  private int $id;
  private int $star;
  private int $idUser;
  private int $idProduct;
  private bool $state;

  /**
   * Get the value of id
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Get the value of star
   */
  public function getStar() {
    return $this->star;
  }

  /**
   * Get the value of idUser
   */
  public function getIdUser() {
    return $this->idUser;
  }

  /**
   * Get the value of idProduct
   */
  public function getIdProduct() {
    return $this->idProduct;
  }

  /**
   * Get the value of state
   */
  public function getState() {
    return $this->state;
  }
}
