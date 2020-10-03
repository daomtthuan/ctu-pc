<?php

namespace Controllers;

use Core\Bases\IGetableController;
use Core\Request;
use Core\Response;

class Index implements IGetableController {
  public static function mapUrl() {
    return '/';
  }

  public static function get(Request $request, Response $response) {
    $log = [
      'Web service' => 'Web service is running',
    ];

    $response->sendText(print_r($log, true));
  }
};
