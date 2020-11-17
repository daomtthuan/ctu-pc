<?php

namespace Core;

use PDO;
use PDOException;

/** Database */
class Database {
  public const INNER_JOIN = 'inner join';
  public const LEFT_OUTER_JOIN = 'left outer join';
  public const RIGHT_OUTER_JOIN = 'right outer join';
  public const CROSS_JOIN = 'cross join';

  private static Database $instance;
  private PDO $connection;

  /** 
   * Create new instance of Database
   * 
   * @throws PDOException — if the attempt to connect to the requested database fails
   */
  private function __construct() {
    $this->connection = new PDO($_ENV['DATABASE_DNS'], $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD'], [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $this->connection->query('set names utf8mb4 collate utf8mb4_unicode_ci')->execute();
    $this->connection->query('set character set utf8mb4')->execute();
    $this->connection->query('set session collation_connection = utf8mb4_unicode_ci')->execute();
    $this->connection->query('set time_zone = \'+7:00\'')->execute();
  }

  /** 
   * Get instance of Database 
   * 
   * @return Database Database
   * 
   * @throws PDOException — if the attempt to connect to the requested database fails
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new Database();
    }
    return self::$instance;
  }

  /**
   * Find entities
   * 
   * @param string $entity Entity name
   * @param array $filter Finding filter
   * 
   * @return array Entities
   */
  public function find(string $entity, array $filter = null) {
    $query = "select * from $entity";
    if (isset($filter)) {
      $query .= ' where ';
      foreach (array_keys($filter) as $key) {
        $query .= "$key = :$key and ";
      }
      $query = substr($query, 0, -5);
    }
    $statement = $this->connection->prepare($query);
    $statement->execute($filter);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Create Reference in Join find
   * 
   * @param string $joinEntity Name join entity
   * @param string $leftEntity Name left entity
   * @param string $leftKey Key left entity
   * @param string $rightEntity Name right entity
   * @param string $rightKey Key right entity
   * @param string $typeJoin Type Join
   * 
   * @return array Reference
   */
  public function createReference(string $joinEntity, string $leftEntity, string $leftKey, string $rightEntity, string $rightKey, string $typeJoin) {
    return [
      'joinEntity' => $joinEntity,
      'leftEntity' => $leftEntity,
      'leftKey' => $leftKey,
      'rightEntity' => $rightEntity,
      'rightKey' => $rightKey,
      'typeJoin' => $typeJoin
    ];
  }

  /**
   * Create Reference filter in Join find
   * 
   * @param string $entity Entity filter
   * @param string $key Key entity filter
   * @param string $value Value filter
   * 
   * @return array Reference filter
   */
  public function createReferenceFilter(string $entity, string $key, string $value) {
    return [
      'entity' => $entity,
      'key' => $key,
      'value' => $value
    ];
  }

  /**
   * Create Reference filter in Join find
   * 
   * @param string $entity Entity
   * @param array|null $filter Entity filter
   * 
   * @return array Reference filter
   */
  public function createReferenceFilters(string $entity, array $filter = null) {
    $referenceFilters = [];
    if (isset($filter)) {
      foreach ($filter as $key => $value) {
        $referenceFilters[] = $this->createReferenceFilter($entity, $key, $value);
      }
    }
    return $referenceFilters;
  }

  /**
   * Find join entities
   * 
   * @param string $entity Entity
   * @param array $filter Finding filter
   * @param array $referencesFilters References filters
   * 
   * @return array Entities
   */
  public function findJoin(string $entity, array $references, array $referencesFilters = null) {
    $query = "select $entity.* from $entity";

    foreach ($references as $reference) {
      $joinEntity = $reference['leftEntity'];
      $leftEntity = $reference['leftEntity'];
      $leftKey = $reference['leftKey'];
      $rightEntity = $reference['rightEntity'];
      $rightKey = $reference['rightKey'];
      $typeJoin = $reference['typeJoin'];
      $query .= " $typeJoin $joinEntity on $leftEntity.$leftKey = $rightEntity.$rightKey";
    }

    $filter = null;
    if (isset($referencesFilters)) {
      $filter = [];
      $query .= ' where ';
      foreach ($referencesFilters as $referencesFilter) {
        $entity = $referencesFilter['entity'];
        $key = $referencesFilter['key'];
        $value = $referencesFilter['value'];
        $filterKey = $entity . '_' . $key;
        $filter[$filterKey] = $value;
        $query .= "$entity.$key = :$filterKey and ";
      }
      $query = substr($query, 0, -5);
    }

    $statement = $this->connection->prepare($query);
    $statement->execute($filter);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Create entity
   * 
   * @param string $entity Entity class name
   * @param array $data Data entity
   * 
   * @return int Created id entity
   */
  public function create(string $entity, array $data) {
    $field = '';
    $value = '';
    foreach (array_keys($data) as $key) {
      $field .= "$key, ";
      $value .= ":$key, ";
    }
    $query = "insert into $entity(" . substr($field, 0, -2) . ') value (' . substr($value, 0, -2) . ')';
    $statement = $this->connection->prepare($query);
    $statement->execute($data);
    return $this->connection->lastInsertId();
  }

  /**
   * Edit one
   * 
   * @param string $entity Entity class name
   * @param int $id Id entity
   * @param array $data Data entity
   * 
   * @return int Number of edited entities
   */
  public function edit(string $entity, int $id, array $data) {
    $query = "update $entity set ";
    foreach (array_keys($data) as $key) {
      $query .= "$key = :$key, ";
    }
    $query = substr($query, 0, -2) . ' where id = :id';
    $statement = $this->connection->prepare($query);
    $statement->execute(array_merge(['id' => $id], $data));
    return $statement->rowCount();
  }

  /**
   * Remove entities
   * 
   * @param string $entity Entity name
   * @param array $filter Removing filter
   * 
   * @return array Number of removed entities
   */
  public function remove(string $entity, array $filter = null) {
    $query = "delete from $entity";
    if (isset($filter)) {
      $query .= ' where ';
      foreach (array_keys($filter) as $key) {
        $query .= "$key = :$key and ";
      }
      $query = substr($query, 0, -5);
    }
    $statement = $this->connection->prepare($query);
    $statement->execute($filter);
    return $statement->rowCount();
  }

  /**
   * Do transaction
   * 
   * @param function:void $action Action
   * @param mixed[] ...$parameters Parameters of action
   * 
   * @return bool True if success, otherwise false
   */
  public function doTransaction($action, ...$parameters) {
    try {
      $this->connection->beginTransaction();
      $action(...$parameters);
      $this->connection->commit();
      return true;
    } catch (PDOException $exception) {
      $this->connection->rollBack();
      return false;
    }
  }
}
