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

/** Permission api */
class PermissionApi extends Api {
  public static function mapUrl() {
    return '/api/admin/permission';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    $permissions = [];
    foreach (PermissionProvider::find() as $permission) {
      $data = $permission->jsonSerialize();
      $permissions[] = $data;
    }
    Response::getInstance()->sendJson($permissions);
  }
};
