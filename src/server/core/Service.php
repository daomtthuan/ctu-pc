<?php

namespace Core;

use Dotenv\Dotenv;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use RegexIterator;

/** Web Service */
class Service {
  private static Service $instance;

  private function __construct() {
    // Load vendors
    require_once __ROOT__ . '\\vendor\\autoload.php';

    // Load Environment arguments
    $dotenv = Dotenv::createImmutable(__ROOT__);
    $dotenv->load();

    // Register controllers
    $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__ROOT__ . '\\controllers'));
    foreach (new RegexIterator($allFiles, '/\.php$/') as $file) {
      $content = file_get_contents($file->getRealPath());
      $tokens = token_get_all($content);
      $namespace = '';
      for ($index = 0; isset($tokens[$index]); $index++) {
        if (!isset($tokens[$index][0])) {
          continue;
        }

        // Get namespace name
        if (T_NAMESPACE === $tokens[$index][0]) {
          $index += 2; // Skip namespace keyword and whitespace
          while (isset($tokens[$index]) && is_array($tokens[$index])) {
            $namespace .= $tokens[$index++][1];
          }
        }

        // Get class name
        if (T_CLASS === $tokens[$index][0] && T_WHITESPACE === $tokens[$index + 1][0] && T_STRING === $tokens[$index + 2][0]) {
          $index += 2; // Skip class keyword and whitespace
          $controller = $namespace . '\\' . $tokens[$index][1];

          Router::registerController($controller::mapUrl(), $controller);
          break;
        }
      }
    }
  }

  /** 
   * Get instance of Service 
   * 
   * @return Service Service
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new Service();
    }
    return self::$instance;
  }

  /** Start Web Service */
  public function start() {
    // Set full allowed access control
    Http::setAccessControlAllow('*', '*', '*', '*');

    // Redirect request
    Router::redirectController();
  }
}
