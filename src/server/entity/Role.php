<?php

namespace Entity;

use Core\Entity;

class Role extends Entity {
  private string $name;

  /** 
   * Create new instance of Role
   * 
   * @param array $data Data Role
   */
  public function __construct(array $data) {
    $this->name = (string)$data['name'];
    parent::__construct($data);
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
   * @return string Name
   */
  public function getName() {
    return $this->name;
  }
}
