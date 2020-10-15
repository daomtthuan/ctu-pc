<?php

namespace Controllers\User;

use Core\Controller;

class User extends Controller {
  public static function mapUrl() {
    return '/api/user/user';
  }

  public static function get() {
  }
};
