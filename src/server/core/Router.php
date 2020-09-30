<?php

namespace Core;

use Exception;

/** Routter */
class Router {
  /** List Controller maps */
  private static array $controllers = [];

  /**
   * Register Controller mapping Url
   * 
   * @param string $url Mapping url
   * @param string $name Controller class name
   */
  public static function registerController(string $url, string $name) {
    Router::$controllers[$url] = $name;
  }

  /** Redirect Controller */
  public static function redirectController() {
    $request = Request::getInstance();
    $response = Response::getInstance();

    // Check Controller mapping
    if (!isset(Router::$controllers[$request->getUrl()])) {
      Router::redirectError(404, 'Not found ' . Request::getInstance()->getUrl());
    }

    // Check method in Controller
    $controller = Router::$controllers[$request->getUrl()];
    if (!method_exists($controller, $request->getMethod())) {
      Router::redirectError(405, 'Method ' . $request->getMethod() . ' not allowed');
    }

    // Call method in Controller
    try {
      call_user_func("$controller::" . $request->getMethod(), $request, $response);
    } catch (Exception $exception) {
      Router::redirectError($exception->getCode(), $exception->getMessage());
    }
  }

  /**
   * Redirect error
   * 
   * @param int $statusCode Error Status code
   * @param string|null $message Error message
   */
  public static function redirectError(int $statusCode, string $message = null) {
    Http::setStatus($statusCode);
    Http::setContentType('text');
    if (!isset($message)) {
      Http::setData("Error $statusCode");
    } else {
      Http::setData("Error $statusCode: $message");
    }
    die;
  }
}
