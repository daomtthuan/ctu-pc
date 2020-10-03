<?php

namespace Models;

class Permission {
  private int $id;
  private int $idUser;
  private int $idRole;
  private bool $state;

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
