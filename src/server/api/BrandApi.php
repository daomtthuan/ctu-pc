<?php

namespace Api;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\BrandProvider;

/** Brand api */
class BrandApi extends Api {
  public static function mapUrl() {
    return '/api/brand';
  }

  public static function get() {
    Response::getInstance()->sendJson(BrandProvider::find(['state' => 1]));
  }
};
