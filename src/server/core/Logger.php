<?php

namespace Core;

/** Logger */
class Logger {
  private static Logger $instance;
  private array $serviceLog;

  /** Create new instance of Logger */
  private function __construct() {
    if (!file_exists(__ROOT__ . $_ENV['SERVICE_LOG_DIR'])) {
      mkdir(__ROOT__ . $_ENV['SERVICE_LOG_DIR'], 0777, true);
    }

    $this->serviceLog = [
      'time' => date('H:i:s'),
      'mac' => Request::getInstance()->getAddress('mac'),
      'account' => null,
      'url' => Request::getInstance()->getUrl(),
      'method' => Request::getInstance()->getMethod(),
      'status' => 200
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
   * Set data in service log
   * 
   * @param string Key log
   * @param mixed $value Value log
   */
  public function setServiceLog(string $key, $value) {
    $this->serviceLog[$key] = $value;
  }

  /** Write serivce log */
  public function writeServiceLog() {
    if ($_ENV['LOG'] == 'true' && $this->serviceLog['method'] != 'get') {
      $path = __ROOT__ . $_ENV['SERVICE_LOG_DIR'] . '\\' . date('Y-m-d') . '.log';
      file_put_contents($path, json_encode($this->serviceLog) . "\n", FILE_APPEND);
    }
  }
}
