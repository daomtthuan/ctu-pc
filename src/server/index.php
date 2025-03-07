<?php

use Core\Service;

// Define root dir
define('__ROOT__', __DIR__);

// Autoload
require_once __ROOT__ . '\\vendor\\autoload.php';
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

// Start Web Service
Service::getInstance()->start();
