<?php

namespace Provider;

use Core\Database;
use Core\File;
use Entity\Event;
use Exception;

/** Event provider */
class EventProvider {
  /**
   * Count event by filter
   * 
   * @param array|null $filter Finding filter
   * @param int $start Index starting event
   * @param int $limit Limit number of events for finding
   * @param string[] $orderByKeys Order by keys
   * @param string $typeOrder Type order
   * 
   * @return int Number of events
   */
  public static function count(array $filter = null, int $start = null, $limit = null, array $orderByKeys = null, string $typeOrder = Database::ORDER_ASC) {
    return Database::getInstance()->count('Event', $filter,  $start, $limit, $orderByKeys, $typeOrder);
  }

  /**
   * Find event by filter
   * 
   * @param array|null $filter Finding filter
   * @param int $start Index starting event
   * @param int $limit Limit number of events for finding
   * @param string[] $orderByKeys Order by keys
   * @param string $typeOrder Type order
   * 
   * @return Event[] Events
   */
  public static function find(array $filter = null, int $start = null, $limit = null, array $orderByKeys = null, string $typeOrder = Database::ORDER_ASC) {
    $events = [];
    foreach (Database::getInstance()->find('Event', $filter,  $start, $limit, $orderByKeys, $typeOrder) as $data) {
      $events[] = new Event($data);
    }
    return $events;
  }

  /**
   * Create event
   * 
   * @param Event $event Created event
   * @param array $image Image event
   * @param string $content Content event
   * 
   * @return bool True if success, otherwise false
   */
  public static function create(Event $event, array $image, string $content) {
    return Database::getInstance()->doTransaction(function ($event, $image, $content) {
      $data = $event->jsonSerialize();
      unset($data['id'], $data['post'], $data['imageUrl'], $data['postUrl'], $data['state']);

      $idEvent = Database::getInstance()->create('Event', $data);

      File::moveUploaded($image, $_ENV['ASSET_DIR'] . "\\image\\event\\$idEvent.jpg");

      File::write($_ENV['ASSET_DIR'] . "\\post\\event\\$idEvent.html", $content);
    }, $event, $image, $content);
  }

  /**
   * Edit event
   * 
   * @param Event $event Edited event
   * @param array|null $image Image edited event
   * @param string $content Content edited event
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Event $event, array $image = null, string $content) {
    return Database::getInstance()->doTransaction(function ($event, $image, $content) {
      $data = $event->jsonSerialize();
      unset($data['id'], $data['post'], $data['idAccount'], $data['imageUrl'], $data['postUrl']);

      Database::getInstance()->edit('Event', $event->getId(), $data);

      if (isset($image)) {
        File::moveUploaded($image, $_ENV['ASSET_DIR'] . '\\image\\event\\' . $event->getId() . '.jpg');
      }

      File::write($_ENV['ASSET_DIR'] . '\\post\\event\\' . $event->getId() . '.html', $content);
    }, $event, $image, $content);
  }

  /**
   * Remove event by filter
   * 
   * @param Event $event Id event
   * 
   * @return bool True if success, otherwise false
   */
  public static function remove(Event $event) {
    return Database::getInstance()->doTransaction(function ($id) {
      File::delete($_ENV['ASSET_DIR'] . "\\image\\event\\$id.jpg");
      File::delete($_ENV['ASSET_DIR'] . "\\post\\event\\$id.html");
      return Database::getInstance()->remove('Event', ['id' => $id]) == 1;
    }, $event->getId());
  }
}
