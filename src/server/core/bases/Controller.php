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
   */
  public static function options() {
    Response::getInstance()->sendStatus(200);
  }
}
