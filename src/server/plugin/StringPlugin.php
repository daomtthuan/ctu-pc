<?php

namespace Plugin;

/** String plugin */
class StringPlugin {
  /**
   * Generate random string
   * 
   * @param int $length Length of string
   * 
   * @return string Random string
   */
  public static function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
}
