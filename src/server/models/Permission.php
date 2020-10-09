<?php

namespace Models;

use Core\Bases\Model;

class Permission extends Model {
  private int $id;
  private int $idUser;
  private int $idRole;
  private bool $state;

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'idUser' => $this->getIdUser(),
      'idRole' => $this->getIdRole(),
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
   * Get the value of idUser
   */
  public function getIdUser() {
    return $this->idUser;
  }

  /**
   * Get the value of idRole
   */
  public function getIdRole() {
    return $this->idRole;
  }

  /**
   * Get the value of state
   */
  public function getState() {
    return $this->state;
  }
}
