<?php

namespace core;

/** Url Map */
class Map {
  private static Map $instance;
  private array $controllers;

  private function __construct() {
    $this->controllers = [
      '/users' => 'UserController'
    ];
  }

  /** Get instance of Url Map */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new Map();
    }
    return self::$instance;
  }

  /**
   * Get Controller Class path
   * 
   * @return Core\Controller|false controller class or false if not found controller
   */
  public function getController() {
    $request = Request::getInstance();

    if (!isset($this->controllers[$request->getUrl()])) {
      return false;
    }
    $controller = 'controllers\\' . $this->controllers[$request->getUrl()];

    return new $controller();
  }
}
