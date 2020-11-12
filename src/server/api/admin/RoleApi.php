<?php

namespace Api\Admin;

use Core\Api;
use Core\Database;
use Core\Request;
use Core\Response;
use Entity\Permission;
use Entity\Account;
use Plugin\HtmlPlugin;
use Plugin\MailPlugin;
use Plugin\StringPlugin;
use Provider\PermissionProvider;
use Provider\RoleProvider;
use Provider\AccountProvider;

/** Role api */
class RoleApi extends Api {
  public static function mapUrl() {
    return '/api/admin/role';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    $roles = [];
    foreach (RoleProvider::find() as $role) {
      $data = $role->getData();
      $roles[] = $data;
    }
    Response::getInstance()->sendJson($roles);
  }
};
