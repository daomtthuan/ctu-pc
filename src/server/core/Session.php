<?php

namespace Core;

/** Session */
class Session {
  /** Start Session
   * 
   * @param string|null $token Token for starting session
   * 
   * @return string Token session key
   */
  public static function start(string $token = null) {
    session_name('auth._token.local');
    if (isset($token)) {
      session_id($token);
      session_start();

      Logger::getInstance()->setServiceLog('user', Session::get('user'));
      return $token;
    } else {
      session_start();
      return session_id();
    }
  }

  /**
   * Check has key Session or not
   * 
   * @param string[] $keys Session Keys
   * 
   * @return bool true if has session. Otherwise, false.
   */
  public static function has(string ...$keys) {
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

  /**
   * Get Session data
   * 
   * @param string|null $key Session Key
   * 
   * @return mixed Session datas if $key is null. Otherwise, value of Session has that key
   */
  public static function get(string $key = null) {
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
  public static function set(string $key, $value) {
    return $_SESSION[$key] = $value;
  }

  /**
   * Set Session data
   * 
   * @param string $key Key Session
   * @param mixed $value Value Session
   */
  public static function stop() {
    session_destroy();
  }
}
