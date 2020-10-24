<?php

namespace Core;

use Core\Request;
use Core\Response;

/** Api Base */
abstract class Api {
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
   */
  public static function options() {
    Response::getInstance()->sendStatus(200);
  }
}
