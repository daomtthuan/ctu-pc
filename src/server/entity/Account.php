<?php

namespace Entity;

use Core\Entity;

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
   * Set the value of hash password
   * 
   * @param string $password Hash password
   */
  public function setPassword(string $password) {
    $this->data['password'] = $password;
  }

  /**
   * Get the value of full name
   * 
   * @return string Full name
   */
  public function getFullName() {
    return $this->data['fullName'];
  }

  /**
   * Set the value of full name
   * 
   * @param string $fullName Full name
   */
  public function setFullName(string $fullName) {
    $this->data['fullName'] = $fullName;
  }

  /**
   * Get the value of birthday
   * 
   * @return string Birthday
   */
  public function getBirthday() {
    return $this->data['birthday'];
  }

  /**
   * Set the value of birthday
   * 
   * @param string $birthday Birthday
   */
  public function setBirthday(string $birthday) {
    $this->data['birthday'] = $birthday;
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
   * Set the value of gender
   * 
   * @param int $gender Gender
   */
  public function setGender(int $gender) {
    $this->data['gender'] = $gender;
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
   * Set the value of email
   * 
   * @param string $email Email
   */
  public function setEmail(string $email) {
    $this->data['email'] = $email;
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
   * Set the value of address
   * 
   * @param string $address Address
   */
  public function setAddress(string $address) {
    $this->data['address'] = $address;
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
   * Set the value of phone
   * 
   * @param string $phone Phone
   */
  public function setPhone(string $phone) {
    $this->data['phone'] = $phone;
  }

  /**
   * Get the value of state
   * 
   * @return int State
   */
  public function getState() {
    return $this->data['state'];
  }

  /**
   * Set the value of state
   * 
   * @param int $phone State
   */
  public function setState(int $state) {
    $this->data['state'] = $state;
  }
}
