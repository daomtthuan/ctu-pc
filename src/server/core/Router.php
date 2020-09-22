<?php

namespace core;

/** Routter */
class Router {
  private static Router $instance;

  private function __construct() {
  }

  /** Get instance of Router */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new Router();
    }
    return self::$instance;
  }

  /** Redirect for request */
  public function redirect() {
    $controller = Map::getInstance()->getController();
    if (!$controller) {
      Response::getInstance()->setStatus(404);
      require_once __ROOT__ . "\\errors\\404.php";
    } else {
      $controller->doMethod();
    }
  }
}
