<?php

namespace Controllers\Auth;

use Core\Request;
use Core\Response;

class Login {
  public const URL = "/auth";

  public static function get(Request $request, Response $response) {
    $log = [
      'Web service' => 'Web service is running',
    ];

    $response->sendText(print_r($log, true));
  }
}
