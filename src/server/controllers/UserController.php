<?php

namespace controllers;

use core\Controller;

class UserController extends Controller {
  protected function get() {
    parent::sendText('Hello, I am UserController');
  }
};
