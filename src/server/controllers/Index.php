<?php

namespace Controllers;

use Core\Controller;
use Core\Response;

class Index extends Controller {
  public static function mapUrl() {
    return '/';
  }

  public static function get() {
    Response::getInstance()->sendText('Web service is running');
  }
};
