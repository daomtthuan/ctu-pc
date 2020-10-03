<?php

namespace Models;

use Core\Bases\IModel;

class Category implements IModel {
  private int $id;
  private string $name;
  private int $idCategoryGroup;
  private bool $state;

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'name' => $this->getName(),
      'idCategoryGroup' => $this->getIdCategoryGroup(),
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
   * Get the value of name
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Get the value of idCategoryGroup
   */
  public function getIdCategoryGroup() {
    return $this->idCategoryGroup;
  }

  /**
   * Get the value of state
   */
  public function getState() {
    return $this->state;
  }
}
