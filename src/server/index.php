<?php

use Core\Service;

require_once __DIR__ . '/init.php';

// Start Web Service
$service = Service::getInstance();
$service->start();
