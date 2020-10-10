<?php

namespace Core;

/** Logger */
class Logger {
  /** Service log path dir */
  public const SERVICE_LOG_DIR = __ROOT__ . '\\logs\\service';

  /** Instance of Logger */
  private static Logger $instance;

  /** Data sevice log */
  private array $serviceLog;

  private function __construct() {
    if (!file_exists(Logger::SERVICE_LOG_DIR)) {
      mkdir(Logger::SERVICE_LOG_DIR, 0777, true);
    }

    $this->serviceLog = [
      date('H:i:s'),
      Request::getInstance()->getAddress('mac'),
      Request::getInstance()->getAddress('ip'),
      Request::getInstance()->getMethod(),
      200,
      Request::getInstance()->getUrl()
    ];
  }

  /** 
   * Get instance of Logger 
   * 
   * @return Logger Logger
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new Logger();
    }
    return self::$instance;
  }

  /**
   * Log response
   * 
   * @param int $statusCode Status code
   */
  public function setStatusResponseServiceLog(int $statusCode) {
    $this->serviceLog[4] = $statusCode;
  }

  public function writeServiceLog() {
    $path = Logger::SERVICE_LOG_DIR . '\\' . date('Y-m-d') . '.log';
    $log = implode(" \t\t\t ", $this->serviceLog) . "\n";
    file_put_contents($path, $log, FILE_APPEND);
  }
}
