<?php

namespace Api\Admin\Log;

use Core\Api;
use Core\Request;
use Core\Response;
use DateTime;

/** Service log api */
class ServiceApi extends Api {
  public static function mapUrl() {
    return '/api/admin/log/service';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('date')) {
      Response::getInstance()->sendStatus(400);
    }

    if (!DateTime::createFromFormat('Y-m-d', Request::getInstance()->getParam('date'))) {
      Response::getInstance()->sendStatus(406);
    }

    $logPath = __ROOT__ . $_ENV['SERVICE_LOG_DIR'] . '\\' . Request::getInstance()->getParam('date') . '.log';
    if (!file_exists($logPath)) {
      Response::getInstance()->sendJson([]);
    }

    $logs = [];
    foreach (json_decode('[' . substr(file_get_contents($logPath), 0, -2) . ']', true) as $log) {
      unset($log['requestData'], $log['responseData']);
      $logs[] = $log;
    }
    Response::getInstance()->sendJson($logs);
  }
};
