<?php

namespace Models;

use Core\Bases\Model;

class User extends Model {
  private int $id;
  private string $username;
  private string $password;
  private string $fullName;
  private string $birthday;
  private bool $gender;
  private string $email;
  private string $address;
  private string $phone;
  private bool $state;

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
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Get the value of username
   */
  public function getUsername() {
    return $this->username;
  }

  /**
   * Get the value of password
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * Get the value of full_name
   */
  public function getFullName() {
    return $this->fullName;
  }

  /**
   * Get the value of birthday
   */
  public function getBirthday() {
    return $this->birthday;
  }

  /**
   * Get the value of gender
   */
  public function getGender() {
    return $this->gender;
  }

  /**
   * Get the value of email
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * Get the value of address
   */
  public function getAddress() {
    return $this->address;
  }

  /**
   * Get the value of phone
   */
  public function getPhone() {
    return $this->phone;
  }

  /**
   * Get the value of state
   */
  public function getState() {
    return $this->state;
  }
}
