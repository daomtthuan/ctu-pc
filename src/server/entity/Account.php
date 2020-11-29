<?php

namespace Entity;

use Core\Entity;

class Account extends Entity {
  private string $username;
  private string $password;
  private string $fullName;
  private string $birthday;
  private bool $gender;
  private string $email;
  private string $address;
  private string $phone;

  /** 
   * Create new instance of Account
   * 
   * @param array $data Data Account
   */
  public function __construct(array $data) {
    parent::__construct($data);
    $this->username = (string)$data['username'];
    $this->password = (string)$data['password'];
    $this->fullName = (string)$data['fullName'];
    $this->birthday = (string)$data['birthday'];
    $this->gender = (bool)$data['gender'];
    $this->email = (string)$data['email'];
    $this->address = (string)$data['address'];
    $this->phone = (string)$data['phone'];
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
   * Get the value of username
   * 
   * @return string Username
   */
  public function getUsername() {
    return $this->username;
  }

  /**
   * Get the value of hash password
   * 
   * @return string Hash password
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * Set the value of hash password
   * 
   * @param string $password Hash password
   */
  public function setPassword(string $password) {
    $this->password = $password;
  }

  /**
   * Get the value of full name
   * 
   * @return string Full name
   */
  public function getFullName() {
    return $this->fullName;
  }

  /**
   * Set the value of full name
   * 
   * @param string $fullName Full name
   */
  public function setFullName(string $fullName) {
    $this->fullName = $fullName;
  }

  /**
   * Get the value of birthday
   * 
   * @return string Birthday
   */
  public function getBirthday() {
    return $this->birthday;
  }

  /**
   * Set the value of birthday
   * 
   * @param string $birthday Birthday
   */
  public function setBirthday(string $birthday) {
    $this->birthday = $birthday;
  }


  /**
   * Get the value of gender
   * 
   * @return bool Gender
   */
  public function getGender() {
    return $this->gender;
  }

  /**
   * Set the value of gender
   * 
   * @param bool $gender Gender
   */
  public function setGender(bool $gender) {
    $this->gender = $gender;
  }

  /**
   * Get the value of email
   * 
   * @return string Email
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * Set the value of email
   * 
   * @param string $email Email
   */
  public function setEmail(string $email) {
    $this->email = $email;
  }

  /**
   * Get the value of address
   * 
   * @return string Address
   */
  public function getAddress() {
    return $this->address;
  }

  /**
   * Set the value of address
   * 
   * @param string $address Address
   */
  public function setAddress(string $address) {
    $this->address = $address;
  }


  /**
   * Get the value of phone
   * 
   * @return string Phone
   */
  public function getPhone() {
    return $this->phone;
  }

  /**
   * Set the value of phone
   * 
   * @param string $phone Phone
   */
  public function setPhone(string $phone) {
    $this->phone = $phone;
  }
}
