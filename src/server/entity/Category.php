<?php

namespace Entity;

use Core\Entity;

class Category extends Entity {
  private string $name;
  private int $idCategoryGroup;

  /** 
   * Create new instance of Category
   * 
   * @param array $data Data Category
   */
  public function __construct(array $data) {
    parent::__construct($data);
    $this->name = (string)$data['name'];
    $this->idCategoryGroup = (int)$data['idCategoryGroup'];
  }

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'name' => $this->getName(),
      'idCategoryGroup' => $this->getIdCategoryGroup(),
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
   * @param string name
   */
  public function setName(string $name) {
    $this->name = $name;
  }

  /**
   * Get the value of idCategoryGroup
   * 
   * @return int Id CategoryGroup
   */
  public function getIdCategoryGroup() {
    return $this->idCategoryGroup;
  }

  /**
   * Set the value of IdCategoryGroup
   * 
   * @param int IdCategoryGroup
   */
  public function setIdCategoryGroup(int $idCategoryGroup) {
    $this->idCategoryGroup = $idCategoryGroup;
  }
}
