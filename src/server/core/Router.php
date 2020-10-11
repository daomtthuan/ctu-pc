<?php

namespace Core;

use Exception;

/** Routter */
class Router {
  public const CONTROLLER_DIR = __ROOT__ . '\\controllers';

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
    // Check Controller mapping
    if (!isset($this->controllers[Request::getInstance()->getUrl()])) {
      $this->redirectError(404, 'Not found ' . Request::getInstance()->getUrl());
    }

    // Check method in Controller
    $controller = $this->controllers[Request::getInstance()->getUrl()];
    if (!method_exists($controller, Request::getInstance()->getMethod())) {
      $this->redirectError(405, 'Method ' . Request::getInstance()->getMethod() . ' not allowed');
    }

    // Call method in Controller
    try {
      call_user_func("$controller::" . Request::getInstance()->getMethod());
    } catch (Exception $exception) {
      $this->redirectError($exception->getCode(), $exception->getMessage());
    }

    Service::getInstance()->stop();
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
    Logger::getInstance()->setServiceLog('status', $statusCode);

    Service::getInstance()->stop();
  }
}
