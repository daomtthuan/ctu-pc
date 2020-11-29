<?php

namespace Core;

use PDO;
use PDOException;

/** Database */
class Database {
  public const JOIN_INNER = 'inner join';
  public const JOIN_LEFT_OUTER = 'left outer join';
  public const JOIN_RIGHT_OUTER = 'right outer join';
  public const JOIN_CROSS = 'cross join';
  public const ORDER_ASC = 'asc';
  public const ORDER_DESC = 'desc';

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
   * @param int $start Index starting entity
   * @param int $limit Limit number of entities for finding
   * @param string[] $orderByKeys Order by keys
   * @param string $typeOrder Type order
   * 
   * @return int Number of entities
   */
  public function count(string $entity, array $filter = null, $start = null, int $limit = null, array $orderByKeys = null, string $typeOrder = Database::ORDER_ASC) {
    $query = "select count(*) as count from $entity";
    if (isset($filter)) {
      $query .= ' where ';
      foreach (array_keys($filter) as $key) {
        $query .= "$key = :$key and ";
      }
      $query = substr($query, 0, -5);
    }

    if (isset($orderByKeys)) {
      $query .= " order by ";
      foreach ($orderByKeys as $key) {
        $query .= "$key, ";
      }
      $query = substr($query, 0, -2) . " $typeOrder";
    }

    if (isset($start, $limit)) {
      $query .= " limit $start, $limit";
    }

    $statement = $this->connection->prepare($query);
    $statement->execute($filter);
    return (int)$statement->fetchAll(PDO::FETCH_ASSOC)[0]['count'];
  }

  /**
   * Find entities
   * 
   * @param string $entity Entity name
   * @param array $filter Finding filter
   * @param int $start Index starting entity
   * @param int $limit Limit number of entities for finding
   * @param string[] $orderByKeys Order by keys
   * @param string $typeOrder Type order
   * 
   * @return array Entities
   */
  public function find(string $entity, array $filter = null, $start = null, int $limit = null, array $orderByKeys = null, string $typeOrder = Database::ORDER_ASC) {
    $query = "select * from $entity";
    if (isset($filter)) {
      $query .= ' where ';
      foreach (array_keys($filter) as $key) {
        $query .= "$key = :$key and ";
      }
      $query = substr($query, 0, -5);
    }

    if (isset($orderByKeys)) {
      $query .= " order by ";
      foreach ($orderByKeys as $key) {
        $query .= "$key, ";
      }
      $query = substr($query, 0, -2) . " $typeOrder";
    }

    if (isset($start, $limit)) {
      $query .= " limit $start, $limit";
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
      'typeJoin' => $typeJoin,
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
   * @param array $references References
   * @param array $referencesFilters References filters
   * 
   * @return array Entities array or Array has two elements are query and filter
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
   * Find entities int or not in references
   * 
   * @param string $entity Entity name
   * @param string $key Key of entity for checking value
   * @param bool $in In or not in references
   * @param array $references References
   * @param array $referencesFilters References filters
   * @param array $filter Finding filter
   * 
   * @return array Entities
   */
  public function findInJoin(string $entity, string $key, bool $in, array $references, array $referencesFilters = null, array $filter = null) {
    $joinQuery = "select $entity.$key from $entity";

    foreach ($references as $reference) {
      $joinEntity = $reference['leftEntity'];
      $leftEntity = $reference['leftEntity'];
      $leftKey = $reference['leftKey'];
      $rightEntity = $reference['rightEntity'];
      $rightKey = $reference['rightKey'];
      $typeJoin = $reference['typeJoin'];
      $joinQuery .= " $typeJoin $joinEntity on $leftEntity.$leftKey = $rightEntity.$rightKey";
    }

    $joinFilter = null;
    if (isset($referencesFilters)) {
      $joinFilter = [];
      $joinQuery .= ' where ';
      foreach ($referencesFilters as $referencesFilter) {
        $joinEntity = $referencesFilter['entity'];
        $joinKey = $referencesFilter['key'];
        $joinValue = $referencesFilter['value'];
        $joinFilterKey = 'j' . $joinEntity . '_' . $joinKey;
        $joinFilter[$joinFilterKey] = $joinValue;
        $joinQuery .= "$joinEntity.$joinKey = :$joinFilterKey and ";
      }
      $joinQuery = substr($joinQuery, 0, -5);
    }

    $query = "select $entity.* from $entity where $entity.$key " . ($in ? 'in' : 'not in') . " ($joinQuery)";
    $findFilter = null;
    if (isset($filter)) {
      $findFilter = [];
      foreach (array_keys($filter) as $key => $value) {
        $findFilterKey = $entity . '_' . $key;
        $findFilter[$findFilterKey] = $value;
        $query .= " and $entity.$key = :$findFilterKey";
      }
    }

    $statement = $this->connection->prepare($query);
    $filter = array_merge(isset($joinFilter) ? $joinFilter : [], isset($findFilter) ? $findFilter : []);
    $statement->execute(count($filter) == 0 ? null : $filter);
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
   * Remove entities int or not in references
   * 
   * @param string $entity Entity name
   * @param string $key Key of entity for checking value
   * @param bool $in In or not in references
   * @param array $references References
   * @param array $referencesFilters References filters
   * @param array $filter Finding filter
   * 
   * @return array Entities
   */
  public function removeInJoin(string $entity, string $key, bool $in, array $references, array $referencesFilters = null, array $filter = null) {
    $joinQuery = "select $entity.$key from $entity";

    foreach ($references as $reference) {
      $joinEntity = $reference['leftEntity'];
      $leftEntity = $reference['leftEntity'];
      $leftKey = $reference['leftKey'];
      $rightEntity = $reference['rightEntity'];
      $rightKey = $reference['rightKey'];
      $typeJoin = $reference['typeJoin'];
      $joinQuery .= " $typeJoin $joinEntity on $leftEntity.$leftKey = $rightEntity.$rightKey";
    }

    $joinFilter = null;
    if (isset($referencesFilters)) {
      $joinFilter = [];
      $joinQuery .= ' where ';
      foreach ($referencesFilters as $referencesFilter) {
        $joinEntity = $referencesFilter['entity'];
        $joinKey = $referencesFilter['key'];
        $joinValue = $referencesFilter['value'];
        $joinFilterKey = 'j' . $joinEntity . '_' . $joinKey;
        $joinFilter[$joinFilterKey] = $joinValue;
        $joinQuery .= "$joinEntity.$joinKey = :$joinFilterKey and ";
      }
      $joinQuery = substr($joinQuery, 0, -5);
    }

    $query = "delete from $entity where $entity.$key " . ($in ? 'in' : 'not in') . " ($joinQuery)";
    $findFilter = null;
    if (isset($filter)) {
      $findFilter = [];
      foreach (array_keys($filter) as $key => $value) {
        $findFilterKey = $entity . '_' . $key;
        $findFilter[$findFilterKey] = $value;
        $query .= " and $entity.$key = :$findFilterKey";
      }
    }

    $statement = $this->connection->prepare($query);
    $filter = array_merge(isset($joinFilter) ? $joinFilter : [], isset($findFilter) ? $findFilter : []);

    $statement->execute(count($filter) == 0 ? null : $filter);
    return $statement->rowCount();
  }

  /**
   * Do transaction
   * 
   * @param function:void $action Action
   * @param mixed[] ...$parameters Parameters of action
   * 
   * @return mixed|bool Result of returning action or True if success, otherwise false
   */
  public function doTransaction($action, ...$parameters) {
    try {
      $this->connection->beginTransaction();
      $reuslt = $action(...$parameters);
      $this->connection->commit();
      return isset($reuslt) ? $reuslt : true;
    } catch (PDOException $exception) {
      $this->connection->rollBack();
      return false;
    }
  }
}
