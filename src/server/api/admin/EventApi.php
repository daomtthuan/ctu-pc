<?php

namespace Api\Admin;

use Core\Api;
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

    $success = EventProvider::create(
      new Event([
        'id' => null,
        'title' => Request::getInstance()->getData('title'),
        'post' => null,
        'idAccount' => $account->getId(),
        'state' => null
      ]),
      Request::getInstance()->getFile('image'),
      Request::getInstance()->getData('content')
    );

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }

  public static function put() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id') || !Request::getInstance()->hasData('title', 'content', 'state')) {
      Response::getInstance()->sendStatus(400);
    }

    $events = EventProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($events) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $events[0]->setTitle(Request::getInstance()->getData('title'));
    $events[0]->setState(Request::getInstance()->getData('state'));

    $success = EventProvider::edit(
      $events[0],
      Request::getInstance()->hasFile('image') ? Request::getInstance()->getFile('image') : null,
      Request::getInstance()->getData('content')
    );

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }

  public static function delete() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendStatus(400);
    }

    $events = EventProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($events) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $success = EventProvider::remove($events[0]->getId());

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
