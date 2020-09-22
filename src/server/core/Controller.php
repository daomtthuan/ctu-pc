<?php

namespace core;

/** Base Controller */
class Controller {
  public function __construct() {
    Response::getInstance()->setAccessControlAllow('*', '*', '*', '*');
  }

  /** Do GET Method */
  protected function get() {
    $this->sendError(405);
  }

  /** Do POST Method */
  protected function post() {
    $this->sendError(405);
  }

  /** Do PUT Method */
  protected function put() {
    $this->sendError(405);
  }

  /** Do DELETE Method */
  protected function delete() {
    $this->sendError(405);
  }

  /**
   * Send JSON Data
   * 
   * @param array $data Data for sending
   */
  protected function sendJson(array $data) {
    Response::getInstance()->setContentType('json');
    Response::getInstance()->setStatus(200);
    Response::getInstance()->setData(json_encode($data));
  }

  /**
   * Send Text Data
   * 
   * @param string $data Data for sending
   */
  protected function sendText(string $data) {
    Response::getInstance()->setContentType('text');
    Response::getInstance()->setStatus(200);
    Response::getInstance()->setData($data);
  }

  /**
   * Send Text Data
   * 
   * @param string $statusCode Error Status code
   * @param string $contentType Content Type of sending Data
   * @param string $data Data for sending
   */
  protected function sendError(int $statusCode) {
    Response::getInstance()->setStatus($statusCode);
    require_once __ROOT__ . "\\errors\\$statusCode.php";
  }

  /** Do Method */
  public function doMethod() {
    switch (Request::getInstance()->getMethod()) {
      case 'get':
        $this->get();
        break;

      case 'post':
        $this->post();
        break;

      case 'put':
        $this->put();
        break;

      case 'delete':
        $this->delete();
        break;
    }
  }
}
