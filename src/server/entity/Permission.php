<?php

namespace Entity;

use Core\Entity;

class Permission extends Entity {
  private int $idAccount;
  private int $idRole;

  /** 
   * Create new instance of Permission
   * 
   * @param array $data Data Permission
   */
  public function __construct(array $data) {
    $this->idAccount = (int)$data['idAccount'];
    $this->idRole = (int)$data['idRole'];
    parent::__construct($data);
  }

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'idAccount' => $this->getIdAccount(),
      'idRole' => $this->getIdRole(),
      'state' => $this->getState()
    ];
  }

  /**
   * Get the value of idAccount
   * 
   * @return int Id Account
   */
  public function getIdAccount() {
    return $this->idAccount;
  }

  /**
   * Get the value of idRole
   * 
   * @return int Id role
   */
  public function getIdRole() {
    return $this->idRole;
  }
}
