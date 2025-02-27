<?php

namespace Api;

use Core\Api;
use Core\Response;

/** Index api */
class IndexApi extends Api {
  public static function mapUrl() {
    return '/';
  }

  public static function get() {
    Response::getInstance()->sendText('Web service is running');
  }
};
