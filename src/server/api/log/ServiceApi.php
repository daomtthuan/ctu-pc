<?php

namespace Api\Log;

use Core\Api;
use Core\Request;
use Core\Response;
use DateTime;

/** Service log api */
class ServiceApi extends Api {
  public static function mapUrl() {
    return '/api/log/service';
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

    Response::getInstance()->sendJsonString('[' . substr(file_get_contents($logPath), 0, -2) . ']');
  }
};
