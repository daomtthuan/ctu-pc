<?php

use Dotenv\Dotenv;

// define root src
define('__ROOT__', __DIR__);

// Load vendors
require_once __ROOT__ . '\\vendor\\autoload.php';

// Load Environment arguments
$dotenv = Dotenv::createImmutable(__ROOT__);
$dotenv->load();

// Autoload class
spl_autoload_register(function ($className) {
  $className = ltrim($className, '\\');
  $fileName  = '';
  $namespace = '';
  if ($lastNsPos = strrpos($className, '\\')) {
    $namespace = substr($className, 0, $lastNsPos);
    $className = substr($className, $lastNsPos + 1);
    $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
  }
  $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

  require_once __ROOT__ . "\\$fileName";
});

// Timezone
date_default_timezone_set("Asia/Ho_Chi_Minh");
