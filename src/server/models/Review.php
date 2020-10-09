<?php

namespace Models;

use Core\Bases\Model;

class Review extends Model {
  private int $id;
  private int $star;
  private int $idUser;
  private int $idProduct;
  private bool $state;

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'star' => $this->getStar(),
      'idUser' => $this->getidUser(),
      'idProduct' => $this->getIdProduct(),
      'state' => $this->getState()
    ];
  }

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
