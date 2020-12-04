<?php

namespace Entity;

use Core\Entity;
use Provider\AccountProvider;

class Review extends Entity {
  private int $star;
  private int $idAccount;
  private int $idProduct;
  private string $content;

  /** 
   * Create new instance of Review
   * 
   * @param array $data Data Review
   */
  public function __construct(array $data) {
    parent::__construct($data);
    $this->star = (int)$data['star'];
    $this->idAccount = (int)$data['idAccount'];
    $this->idProduct = (int)$data['idProduct'];
    $this->content = (string)$data['content'];
  }

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'star' => $this->getStar(),
      'idAccount' => $this->getidAccount(),
      'idProduct' => $this->getIdProduct(),
      'content' => $this->getContent(),
      'state' => $this->getState()
    ];
  }

  /**
   * Get writer account
   * 
   * @return Account Writer account
   */
  public function getWriterAccount() {
    return AccountProvider::find(['id' => $this->idAccount])[0];
  }

  /**
   * Get the value of star
   * 
   * @return int Star
   */
  public function getStar() {
    return $this->star;
  }

  /**
   * Set the value of star
   * 
   * @param int star
   */
  public function setStar(int $star) {
    $this->star = $star;
  }

  /**
   * Get the value of idAccount
   * 
   * @return int IdAccount
   */
  public function getIdAccount() {
    return $this->idAccount;
  }

  /**
   * Set the value of idAccount
   * 
   * @param int id account
   */
  public function setIdAccount(int $idAccount) {
    $this->idAccount = $idAccount;
  }

  /**
   * Get the value of idProduct
   * 
   * @return int IdProduct
   */
  public function getIdProduct() {
    return $this->idProduct;
  }

  /**
   * Set the value of idProduct
   * 
   * @param int id product
   */
  public function setIdProduct(int $idProduct) {
    $this->idProduct = $idProduct;
  }

  /**
   * Get the value of content
   * 
   * @return string Content
   */
  public function getContent() {
    return $this->content;
  }

  /**
   * Set the value of content
   * 
   * @param string Content
   */
  public function setContent(string $content) {
    $this->content = $content;
  }
}
