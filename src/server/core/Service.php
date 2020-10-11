<?php

namespace Core;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

/** Web Service */
class Service {

  /** Instance of Service  */
  private static Service $instance;

  /** Create new instance of Service */
  private function __construct() {
    // Register controllers
    $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(Router::CONTROLLER_DIR));
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

          Router::getInstance()->registerController(strtolower($controller::mapUrl()), $controller);
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
    // Init Logger
    Logger::getInstance();

    // Redirect request
    Router::getInstance()->redirectController();
  }

  /** Stop Web Service */
  public function stop() {
    // Write log
    Logger::getInstance()->writeServiceLog();
    exit;
  }

  /** Start Session
   * 
   * @param string|null $token Token for starting session
   * 
   * @return string Token session key
   */
  public function startSession(string $token = null) {
    session_name('auth._token.local');
    session_id($token);
    session_start();
    return session_id();
  }

  /**
   * Get Session data
   * 
   * @param string|null $key Session Key
   * 
   * @return mixed Session datas if $key is null. Otherwise, value of Session has that key
   */
  public function getSession(string $key = null) {
    if (!isset($key)) {
      return $_SESSION;
    } else {
      return $_SESSION[$key];
    }
  }

  /**
   * Set Session data
   * 
   * @param string $key Key Session
   * @param mixed $value Value Session
   */
  public function setSession(string $key, $value) {
    return $_SESSION[$key] = $value;
  }

  /**
   * Check has session or not
   * 
   * @param string[] $keys Session Keys
   * 
   * @return bool true if has session. Otherwise, false.
   */
  public function hasSession(string ...$keys) {
    if (count($keys) == 0) {
      return count($_SESSION) > 0;
    } else {
      foreach ($keys as $key) {
        if (!isset($_SESSION[$key])) {
          return false;
        }
      }
      return true;
    }
  }
}
