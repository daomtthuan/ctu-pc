<?php

namespace Controllers;

use Core\Request;
use Core\Response;

class Index {
  public static function get(Request $request, Response $response) {
    $log = [
      'Web service' => 'Web service is running',
    ];

    $response->sendText(print_r($log, true));
  }
};
