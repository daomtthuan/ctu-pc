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

    if (!Request::getInstance()->hasData('title', 'content') || !Request::getInstance()->hasFile('image')) {
      Response::getInstance()->sendStatus(400);
    }

    $success = Database::getInstance()->doTransaction(function ($idAccount) {
      $idEvent = EventProvider::create(new Event([
        'id' => null,
        'title' => Request::getInstance()->getData('title'),
        'post' => null,
        'idAccount' => $idAccount,
        'state' => null
      ]));

      File::moveUploaded(Request::getInstance()->getFile('image'), $_ENV['ASSET_DIR'] . "\\image\\event\\$idEvent.jpg");

      File::write($_ENV['ASSET_DIR'] . "\\post\\event\\$idEvent.html", Request::getInstance()->getData('content'));
    }, $account->getId());

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }

  public static function put() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id') || !Request::getInstance()->hasData('title', 'content', 'state')) {
      Response::getInstance()->sendStatus(400);
    }

    $events = EventProvider::find(['id' => Request::getInstance()->getParam('id')]);
    if (count($events) != 1) {
      Response::getInstance()->sendStatus(406);
    }

    $success = Database::getInstance()->doTransaction(function ($events) {
      /** @var Event */
      $event = $events[0];
      $event->setTitle(Request::getInstance()->getData('title'));
      $event->setState(Request::getInstance()->getData('state') == 'true' ? true : false);
      EventProvider::edit($event);

      if (Request::getInstance()->hasFile('image')) {
        $imageUrl = $_ENV['ASSET_DIR'] . '\\image\\event\\' . $event->getId() . '.jpg';
        File::moveUploaded(Request::getInstance()->getFile('image'), $imageUrl);
      }

      File::write($_ENV['ASSET_DIR'] . '\\post\\event\\' . $event->getId() . '.html', Request::getInstance()->getData('content'));
    }, $events);

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }

  public static function delete() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendStatus(400);
    }

    $success = Database::getInstance()->doTransaction(function ($id) {
      File::delete($_ENV['ASSET_DIR'] . "\\image\\event\\$id.jpg");
      File::delete($_ENV['ASSET_DIR'] . "\\post\\event\\$id.html");
      EventProvider::remove(['id' => $id]);
    }, Request::getInstance()->getParam('id'));

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
