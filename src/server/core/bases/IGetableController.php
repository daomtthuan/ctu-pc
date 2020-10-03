<?php

namespace Core\Bases;

use Core\Request;
use Core\Response;

interface IGetableController extends IController {
  /**
   * Get method
   * 
   * @param Request $request Request
   * @param Response $response Response
   * 
   * @return void
   */
  public static function get(Request $request, Response $response);
}
