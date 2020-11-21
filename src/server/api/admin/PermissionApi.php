<?php

namespace Api\Admin;

use Core\Api;
use Core\Request;
use Core\Response;
use Entity\Permission;
use Provider\AccountProvider;
use Provider\PermissionProvider;

/** Permission api */
class PermissionApi extends Api {
  public static function mapUrl() {
    return '/api/admin/permission';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('idRole')) {
      Response::getInstance()->sendStatus(400);
    }

    $notIn = Request::getInstance()->hasParam('notIn');

    $filter = Request::getInstance()->getParam();
    unset($filter['idRole'], $filter['notIn']);
    $accounts = [];
    foreach (($notIn ?
      AccountProvider::findNotOwnRole(Request::getInstance()->getParam('idRole'), $filter) :
      AccountProvider::findOwnRole(Request::getInstance()->getParam('idRole'), $filter)) as $account) {
      $data = $account->jsonSerialize();
      unset($data['password']);
      $accounts[] = $data;
    }
    Response::getInstance()->sendJson($accounts);
  }

  public static function post() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasData('idRole', 'idAccount')) {
      Response::getInstance()->sendStatus(400);
    }

    PermissionProvider::create(new Permission([
      'idAccount' => Request::getInstance()->getData('idAccount'),
      'idRole' => Request::getInstance()->getData('idRole')
    ]));
  }
};
