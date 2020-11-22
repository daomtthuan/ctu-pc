<?php

namespace Entity;

use Core\Entity;

class Brand extends Entity {
  private string $name;

  /** 
   * Create new instance of Brand
   * 
   * @param array $data Data Brand
   */
  public function __construct(array $data) {
    parent::__construct($data);
    $this->name = (string)$data['name'];
  }

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'name' => $this->getName(),
      'state' => $this->getState()
    ];
  }

  /**
   * Get the value of name
   * 
   * @return String Name
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set the value of Name
   * 
   * @param string name
   */
  public function setName(string $name) {
    $this->name = $name;
  }
}
