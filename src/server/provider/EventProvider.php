<?php

namespace Provider;

use Core\Database;
use Entity\Event;

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
   * Create Event
   * 
   * @param Event $event Created Event
   * 
   * @return int Id event
   */
  public static function create(Event $event) {
    $data = $event->jsonSerialize();
    unset($data['id'], $data['post'], $data['imageUrl'], $data['postUrl'], $data['state']);
    return Database::getInstance()->create('Event', $data);
  }

  /**
   * Edit Event
   * 
   * @param Event $event Edited Event
   * 
   * @return bool True if success, otherwise false
   */
  public static function edit(Event $event) {
    $data = $event->jsonSerialize();
    unset($data['id'], $data['post'], $data['idAccount'], $data['imageUrl'], $data['postUrl']);
    return Database::getInstance()->edit('Event', $event->getId(), $data);
  }
}
