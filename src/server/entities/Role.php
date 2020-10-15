<?php

namespace Entities;

use Core\Entity;

class Role extends Entity {
  /**
   * Create new instance of Role
   * 
   * @param array $data Data
   */
  public function __construct(array $data) {
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
   * Get the value of id
   * 
   * @return int Id
   */
  public function getId() {
    return $this->data['id'];
  }

  /**
   * Get the value of name
   * 
   * @return string Name
   */
  public function getName() {
    return $this->data['name'];
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
