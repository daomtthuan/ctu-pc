<?php

namespace Core;

use Core\Bases\Model;
use Exception;
use PDO;

/** Database */
class Database {
  /** Instance of Logger */
  private static Database $instance;

  /** Connection */
  private PDO $connection;

  /** Create new instance of Database */
  private function __construct() {
  }

  /** 
   * Get instance of Database 
   * 
   * @return Database Database
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new Database();
    }
    return self::$instance;
  }

  /** Open connection */
  public function open() {
    $this->connection = new PDO($_ENV['DATABASE_DNS'], $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD']);
  }

  /** Close connection */
  public function close() {
    unset($this->connection);
  }

  /**
   * Select Model in database
   * 
   * @param string $model Name model
   * @param array $parameters Query parameters
   * 
   * @return Model[] Models array
   */
  public function select(string $model, array $parameters = null) {
    try {
      $this->open();

      // Prepare query
      $query = "select * from $model";
      if (isset($parameters)) {
        $query .= ' where';
        foreach (array_keys($parameters) as $parameter) {
          $query .= " $parameter = :$parameter and";
        }
        $query = substr($query, 0, -4);
      }
      $statement = $this->connection->prepare($query);

      // Model mapping
      $statement->setFetchMode(PDO::FETCH_CLASS, "Models\\$model");

      // Execute
      $statement->execute($parameters);

      $this->close();

      // Fetch to array Models
      return $statement->fetchAll();
    } catch (Exception $exception) {
      Router::getInstance()->redirectError(500, $exception->getMessage());
    }
  }
}
