<?php

namespace Core;

/** Request */
class Request {
  private static Request $instance;

  private string $url;
  private string $method;
  private array $data;

  private function __construct() {
    // Get reques url 
    $this->url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
    $this->url = substr($this->url, strlen($_ENV['SERVER_PREFIX_URL']));

    // Get reques method 
    $this->method = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD'])  : 'get';

    // Get request data
    if (isset($_SERVER['CONTENT_TYPE'])) {
      if (strpos(strtolower($_SERVER['CONTENT_TYPE']), 'application/json') !== false) {
        $this->data = json_decode(file_get_contents('php://input'), true);
      }
    }
  }

  /** 
   * Get instance of Request 
   * 
   * @return Request Request
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new Request();
    }
    return self::$instance;
  }

  /**
   * Get the value of url
   */
  public function getUrl() {
    return $this->url;
  }

  /**
   * Get the value of method
   */
  public function getMethod() {
    return $this->method;
  }

  /**
   * Get the value of data
   */
  public function getData() {
    return $this->data;
  }
}
