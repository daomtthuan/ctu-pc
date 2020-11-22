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
    parent::__construct($data);
    $this->idAccount = (int)$data['idAccount'];
    $this->idRole = (int)$data['idRole'];
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
   * Set the value of idAccount
   * 
   * @param int Id Account
   */
  public function setIdAccount(int $idAccount) {
    $this->idAccount = $idAccount;
  }

  /**
   * Get the value of idRole
   * 
   * @return int Id role
   */
  public function getIdRole() {
    return $this->idRole;
  }

  /**
   * Set the value of idRole
   * 
   * @param int Id Role
   */
  public function setIdRole(int $idRole) {
    $this->idRole = $idRole;
  }
}
