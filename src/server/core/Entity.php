<?php

namespace Core;

use JsonSerializable;

/** Entity Base */
abstract class Entity implements JsonSerializable {
  protected int $id;
  protected bool $state;

  /** 
   * Create new instance of Entity
   * 
   * @param array $data Data entity
   */
  protected function __construct(array $data) {
    $this->id = (int)$data['id'];
    $this->state = (bool)$data['state'];
  }

  /**
   * Serialize to JSON Object
   * 
   * @return array JSON Object
   */
  public abstract function jsonSerialize();

  /**
   * Get the value of id
   * 
   * @return int Id
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Get the value of state
   * 
   * @return bool State
   */
  public function getState() {
    return $this->state;
  }

  /**
   * Set the value of state
   * 
   * @param bool State
   */
  public function setState(bool $state) {
    $this->state = $state;
  }
}
