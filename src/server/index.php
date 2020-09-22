<?php

use Core\Service;

// define root src
define('__ROOT__', __DIR__);

require_once __ROOT__ . '\\vendor\\autoload.php';

// Autoload Class
spl_autoload_register(function ($class) {
  require_once __ROOT__ . "\\$class.php";
});


// Start Web Service
Service::getInstance()->start();
