<?php

namespace Api;

use Core\Api;
use Core\Database;
use Core\Request;
use Core\Response;
use Provider\EventProvider;

/** Event api */
class EventApi extends Api {
  public static function mapUrl() {
    return '/api/event';
  }

  public static function get() {
    if (Request::getInstance()->hasParam('count')) {
      $count = EventProvider::count([
        'state' => 1
      ]);
      Response::getInstance()->sendJson([
        'count' => $count
      ]);
    }

    if (Request::getInstance()->hasParam('start', 'limit')) {
      $events = EventProvider::find([
        'state' => 1
      ], Request::getInstance()->getParam('start'), Request::getInstance()->getParam('limit'), ['post'], Database::ORDER_DESC);

      Response::getInstance()->sendJson($events);
    }

    if (Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendJson(EventProvider::find([
        'id' => Request::getInstance()->getParam('id'),
        'state' => 1
      ]));
    }

    Response::getInstance()->sendStatus(400);
  }
};
