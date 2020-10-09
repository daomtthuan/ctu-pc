<?php

namespace Core\Bases;

use Core\Request;
use Core\Response;

/** Controller Base */
abstract class Controller {
  /**
   * Map Request URL
   * 
   * @return string URL mapping
   */
  public abstract static function mapUrl();

  /**
   * Options method
   * 
   * @param Request $request Request
   * @param Response $response Response
   * 
   * @return void
   */
  public static function options(Request $request, Response $response) {
    $response->sendStatus(200);
  }
}
