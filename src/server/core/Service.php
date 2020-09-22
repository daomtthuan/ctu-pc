<?php

namespace core;

use Dotenv\Dotenv;

/** Web Service */
class Service {
  private static Service $instance;

  private function __construct() {
    // Load Environment
    $dotenv = Dotenv::createImmutable(__ROOT__ . '/../');
    $dotenv->load();
  }

  /** Get instance of Service */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new Service();
    }
    return self::$instance;
  }

  /** Start Web Service */
  public function start() {
    // Redirect
    Router::getInstance()->redirect();
  }
}
