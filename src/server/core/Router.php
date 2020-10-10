<?php

namespace Core;

use Exception;

/** Routter */
class Router {
  /** Instance of Routter  */
  private static Router $instance;

  /** List Controllers mapping */
  private array $controllers;

  /** Create new instance of Routter */
  private function __construct() {
    $this->controllers = [];
  }

  /** 
   * Get instance of Router 
   * 
   * @return Router Router
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new Router();
    }
    return self::$instance;
  }

  /**
   * Register Controller mapping Url
   * 
   * @param string $url Mapping url
   * @param string $name Controller class name
   */
  public function registerController(string $url, string $name) {
    $this->controllers[$url] = $name;
  }

  /** Redirect Controller */
  public function redirectController() {
    $request = Request::getInstance();
    $response = Response::getInstance();

    // Check Controller mapping
    if (!isset($this->controllers[$request->getUrl()])) {
      $this->redirectError(404, 'Not found ' . Request::getInstance()->getUrl());
    }

    // Check method in Controller
    $controller = $this->controllers[$request->getUrl()];
    if (!method_exists($controller, $request->getMethod())) {
      $this->redirectError(405, 'Method ' . $request->getMethod() . ' not allowed');
    }

    // Call method in Controller
    try {
      call_user_func("$controller::" . $request->getMethod());
    } catch (Exception $exception) {
      $this->redirectError($exception->getCode(), $exception->getMessage());
    }
  }

  /**
   * Redirect error
   * 
   * @param int $statusCode Error Status code
   * @param string|null $message Error message
   */
  public function redirectError(int $statusCode, string $message = null) {
    Http::setStatus($statusCode);
    Http::setContentType('text');
    if (!isset($message)) {
      Http::setData("Error $statusCode");
    } else {
      Http::setData("Error $statusCode: $message");
    }
    Logger::getInstance()->setStatusResponseServiceLog($statusCode);
    Logger::getInstance()->writeServiceLog();
    die;
  }
}
