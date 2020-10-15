<?php

namespace Entities;

use Core\Entity;

class Permission extends Entity {
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
      'idUser' => $this->getIdUser(),
      'idRole' => $this->getIdRole(),
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
   * Get the value of idUser
   * 
   * @return int Id user
   */
  public function getIdUser() {
    return $this->data['idUser'];
  }

  /**
   * Get the value of idRole
   * 
   * @return int Id role
   */
  public function getIdRole() {
    return $this->data['idRole'];
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
