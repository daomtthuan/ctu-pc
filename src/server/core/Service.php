<?php

namespace Core;

/** Web Service */
class Service {
  /** Start Web Service */
  public static function start() {
    // Set full allowed access control
    Http::setAccessControlAllow('*', '*', '*', '*');

    // Redirect request
    Router::redirectController();
  }
}
