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
    $this->name = (string)$data['name'];
    $this->idCategoryGroup = (int)$data['idCategoryGroup'];
    parent::__construct($data);
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
   * Get the value of idCategoryGroup
   * 
   * @return int Id CategoryGroup
   */
  public function getIdCategoryGroup() {
    return $this->idCategoryGroup;
  }
}
