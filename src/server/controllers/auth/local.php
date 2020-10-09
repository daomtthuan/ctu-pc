<?php

namespace Controllers\Auth;

use Core\Bases\Controller;
use Core\Bases\IGetableController;
use Core\Bases\IPostableController;
use Core\Request;
use Core\Response;

class Local extends Controller implements IGetableController, IPostableController {
  public static function mapUrl() {
    return '/auth/local';
  }

  public static function get(Request $request, Response $response) {
  }

  public static function post(Request $request, Response $response) {
  }
};
