<?php

namespace Entity;

use Core\Entity;
use Provider\AccountProvider;

class Event extends Entity {
  private string $title;
  private string $post;
  private int $idAccount;

  /** 
   * Create new instance of Account
   * 
   * @param array $data Data Account
   */
  public function __construct(array $data) {
    parent::__construct($data);
    $this->title = (string)$data['title'];
    $this->post = (string)$data['post'];
    $this->idAccount = (int)$data['idAccount'];
  }

  public function jsonSerialize() {
    return [
      'id' => $this->getId(),
      'title' => $this->getTitle(),
      'post' => $this->getPost(),
      'idAccount' => $this->getIdAccount(),
      'imageUrl' => $this->getImageUrl(),
      'postUrl' => $this->getPostUrl(),
      'state' => $this->getState()
    ];
  }

  /**
   * Get author account
   * 
   * @return Account Author account
   */
  public function getAuthorAccount() {
    return AccountProvider::find(['id' => $this->idAccount])[0];
  }

  /**
   * Get the value of title
   * 
   * @return string Title
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * Set the value of title
   * 
   * @param string Title
   */
  public function setTitle(string $title) {
    $this->title = $title;
  }

  /**
   * Get the value of post
   * 
   * @return string Post
   */
  public function getPost() {
    return $this->post;
  }

  /**
   * Set the value of post
   * 
   * @param string Post
   */
  public function setPost(string $post) {
    $this->post = $post;
  }

  /**
   * Get the value of idAccount
   * 
   * @return int Id Account
   */
  public function getIdAccount() {
    return $this->idAccount;
  }

  /**
   * Set the value of idAccount
   * 
   * @param int Id Account
   */
  public function setIdAccount(int $idAccount) {
    $this->idAccount = $idAccount;
  }

  /**
   * Get image url
   * 
   * @return string Image url
   */
  public function getImageUrl() {
    return '/asset/image/event/' . $this->id . '.jpg';
  }

  /**
   * Get post url
   * 
   * @return string Post url
   */
  public function getPostUrl() {
    return '/asset/post/event/' . $this->id . '.html';
  }
}
