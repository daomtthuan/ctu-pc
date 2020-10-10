<?php

namespace Core;

use Exception;
use PDO;

/** Database Access Data Provider */
class Database {
  public static function select(string $model, array $parameters = null) {
    try {
      // Open connection
      $connection = new PDO($_ENV['DATABASE_DNS'], $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD']);

      // Prepare query
      $query = "select * from $model";
      if (isset($parameters)) {
        $query .= ' where';
        foreach (array_keys($parameters) as $parameter) {
          $query .= " $parameter = :$parameter and";
        }
        $query = substr($query, 0, -4);
      }
      $statement = $connection->prepare($query);

      // Model mapping
      $statement->setFetchMode(PDO::FETCH_CLASS, "Models\\$model");

      // Execute
      $statement->execute($parameters);

      // Close connection
      unset($connection);

      // Fetch to array Models
      return $statement->fetchAll();
    } catch (Exception $exception) {
      Router::getInstance()->redirectError(500, $exception->getMessage());
    }
  }
}
