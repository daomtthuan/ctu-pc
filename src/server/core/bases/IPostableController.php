<?php

namespace Core\Bases;

use Core\Request;
use Core\Response;

interface IPostableController {
  /**
   * Get method
   * 
   * @param Request $request Request
   * @param Response $response Response
   * 
   * @return void
   */
  public static function post(Request $request, Response $response);
}
