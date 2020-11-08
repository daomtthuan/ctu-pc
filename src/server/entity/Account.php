<?php

namespace Entity;

use Core\Entity;
use DateTime;

class Account extends Entity {
  /**
   * Create new instance of Account
   * 
   * @param array $data Data
   */
  public function __construct(array $data) {
    parent::__construct($data);
  }

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'username' => $this->getUsername(),
      'password' => $this->getPassword(),
      'fullName' => $this->getFullName(),
      'birthday' => $this->getBirthday(),
      'gender' => $this->getGender(),
      'email' => $this->getEmail(),
      'address' => $this->getAddress(),
      'phone' => $this->getPhone(),
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
   * Get the value of username
   * 
   * @return string Username
   */
  public function getUsername() {
    return $this->data['username'];
  }

  /**
   * Get the value of hash password
   * 
   * @return string Hash password
   */
  public function getPassword() {
    return $this->data['password'];
  }

  /**
   * Get the value of fullName
   * 
   * @return string Full name
   */
  public function getFullName() {
    return $this->data['fullName'];
  }

  /**
   * Get the value of birthday
   * 
   * @return DateTime Birthday
   */
  public function getBirthday() {
    return $this->data['birthday'];
  }

  /**
   * Get the value of gender
   * 
   * @return int Gender
   */
  public function getGender() {
    return $this->data['gender'];
  }

  /**
   * Get the value of email
   * 
   * @return string Email
   */
  public function getEmail() {
    return $this->data['email'];
  }

  /**
   * Get the value of address
   * 
   * @return string Address
   */
  public function getAddress() {
    return $this->data['address'];
  }

  /**
   * Get the value of phone
   * 
   * @return string Phone
   */
  public function getPhone() {
    return $this->data['phone'];
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
