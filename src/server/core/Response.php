<?php

namespace Core;

/** Response */
class Response {
  private static Response $instance;

  /** Create new instance of Response */
  private function __construct() {
    // Set full allowed access control
    Http::setAccessControlAllow('*', '*', '*', '*', '*');
  }

  /** 
   * Get instance of Response 
   * 
   * @return Response Response
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new Response();
    }
    return self::$instance;
  }

  /**
   * Send JSON Data
   * 
   * @param mixed $data Sending Data
   */
  public function sendJson($data) {
    Http::setContentType('json');
    Http::setStatus(200);
    Http::setData(json_encode($data));

    Service::getInstance()->stop();
  }

  /**
   * Send Text Data
   * 
   * @param string $data Sending Data
   */
  public function sendText(string $data) {
    Http::setContentType('text');
    Http::setStatus(200);
    Http::setData($data);

    Service::getInstance()->stop();
  }

  /**
   * Send Status
   * 
   * @param int $code Status code
   */
  public function sendStatus(int $code) {
    Http::setStatus($code);
    Logger::getInstance()->setServiceLog('status', $code);

    Service::getInstance()->stop();
  }
}
