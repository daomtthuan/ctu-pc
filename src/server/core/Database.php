<?php

namespace Core;

use Exception;
use PDO;

/** Database */
class Database {
  public const INNER_JOIN = 'inner join';
  public const LEFT_OUTER_JOIN = 'left outer join';
  public const RIGHT_OUTER_JOIN = 'right outer join';
  public const CROSS_JOIN = 'cross join';

  /**
   * Find query
   * 
   * @param string $entity Entity name
   * @param array $filter Finding filter
   * 
   * @return array Data execute results
   */
  public static function find(string $entity, array $filter = null) {
    try {
      $pdo = new PDO($_ENV['DATABASE_DNS'], $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD']);
      $query = "select * from $entity";
      if (isset($filter)) {
        $query .= ' where ';
        foreach (array_keys($filter) as $key) {
          $query .= "$key = :$key and ";
        }
        $query = substr($query, 0, -5);
      }
      $statement = $pdo->prepare($query);
      $statement->execute($filter);
      unset($pdo);
      return $statement->fetchAll();
    } catch (Exception $exception) {
      Router::getInstance()->redirectError(500, $exception->getMessage());
    }
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
  public static function createReference(string $joinEntity, string $leftEntity, string $leftKey, string $rightEntity, string $rightKey, string $typeJoin) {
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
  public static function createReferenceFilter(string $entity, string $key, string $value) {
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
  public static function createReferenceFilters(string $entity, array $filter = null) {
    $referenceFilters = [];
    if (isset($filter)) {
      foreach ($filter as $key => $value) {
        $referenceFilters[] = Database::createReferenceFilter($entity, $key, $value);
      }
    }
    return $referenceFilters;
  }

  /**
   * Find query
   * 
   * @param string $entity Entity
   * @param array $filter Finding filter
   * @param array $referencesFilters References filters
   * 
   * @return array Data execute results
   */
  public static function findJoin(string $entity, array $references, array $referencesFilters = null) {
    try {
      $pdo = new PDO($_ENV['DATABASE_DNS'], $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD']);
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

      $statement = $pdo->prepare($query);
      $statement->execute($filter);
      unset($pdo);
      return $statement->fetchAll();
    } catch (Exception $exception) {
      Router::getInstance()->redirectError(500, $exception->getMessage());
    }
  }

  /**
   * Add new one
   * 
   * @param string $entity Entity
   * @param array $data Adding data
   * 
   * @return int Number of added rows
   */
  public static function add(string $entity, array $data) {
    try {
      $pdo = new PDO($_ENV['DATABASE_DNS'], $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD']);

      $field = '';
      $value = '';
      foreach (array_keys($data) as $key) {
        $field .= "$key, ";
        $value .= ":$key, ";
      }
      $query = "insert into $entity(" . substr($field, 0, -2) . ') value (' . substr($value, 0, -2) . ')';
      $statement = $pdo->prepare($query);
      $statement->execute($data);
      unset($pdo);
      return $statement->rowCount();
    } catch (Exception $exception) {
      Router::getInstance()->redirectError(500, $exception->getMessage());
    }
  }

  /**
   * Edit one
   * 
   * @param string $entity Entity
   * @param int $id Id entity
   * @param array $data Data entity
   * 
   * @return int Number of edited rows
   */
  public static function edit(string $entity, int $id, array $data) {
    try {
      $pdo = new PDO($_ENV['DATABASE_DNS'], $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD']);
      $query = "update $entity set ";
      foreach (array_keys($data) as $key) {
        $query .= "$key = :$key, ";
      }
      $query = substr($query, 0, -2) . ' where id = :id';
      $statement = $pdo->prepare($query);
      $statement->execute(array_merge(['id' => $id], $data));
      unset($pdo);
      return $statement->rowCount();
    } catch (Exception $exception) {
      Router::getInstance()->redirectError(500, $exception->getMessage());
    }
  }
}
