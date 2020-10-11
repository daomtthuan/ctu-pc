<?php

namespace Controllers;

use Core\Bases\Controller;
use Core\Bases\IGetableController;
use Core\Request;
use Core\Response;

class Index extends Controller implements IGetableController {
  public static function mapUrl() {
    return '/api';
  }

  public static function get() {
    $log = [
      'Web service' => 'Web service is running',
      'IP' => Request::getInstance()->getAddress('ip'),
      'MAC' => Request::getInstance()->getAddress('mac')
    ];

    Response::getInstance()->sendText(print_r($log, true));
  }
};
