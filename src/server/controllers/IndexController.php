<?php

namespace Controllers;

use Core\Controller;
use Core\Response;

class IndexController extends Controller {
  public static function mapUrl() {
    return '/api';
  }

  public static function get() {
    Response::getInstance()->sendText('Web service is running');
  }
};
