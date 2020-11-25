<?php

namespace Api\Admin;

use Core\Api;
use Core\Database;
use Core\File;
use Core\Request;
use Core\Response;
use Entity\Event;
use Provider\EventProvider;

/** Admin event api */
class EventApi extends Api {
  public static function mapUrl() {
    return '/api/admin/event';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    $events = [];
    foreach (EventProvider::find(Request::getInstance()->getParam()) as $event) {
      $data = $event->jsonSerialize();
      $data['author'] = $event->getAuthorAccount()->jsonSerialize();
      unset($data['author']['password']);
      $events[] = $data;
    }
    Response::getInstance()->sendJson($events);
  }

  public static function post() {
    $account = Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasForm('title', 'content') || !Request::getInstance()->hasFile('image')) {
      Response::getInstance()->sendStatus(400);
    }

    $success = Database::getInstance()->doTransaction(function ($idAccount) {
      $idEvent = EventProvider::create(new Event([
        'id' => null,
        'title' => Request::getInstance()->getForm('title'),
        'post' => null,
        'idAccount' => $idAccount,
        'state' => null
      ]));

      File::moveUploaded(Request::getInstance()->getFile('image'), $_ENV['ASSET_DIR'] . "\\image\\event\\$idEvent.jpg");

      File::write($_ENV['ASSET_DIR'] . "\\post\\event\\$idEvent.html", Request::getInstance()->getForm('content'));
    }, $account->getId());

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
