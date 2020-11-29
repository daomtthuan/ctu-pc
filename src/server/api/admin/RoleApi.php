<?php

namespace Api\Admin;

use Core\Api;
use Core\Request;
use Core\Response;
use Provider\RoleProvider;

/** Admin role api */
class RoleApi extends Api {
  public static function mapUrl() {
    return '/api/admin/role';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();
    Response::getInstance()->sendJson(RoleProvider::find(Request::getInstance()->getParam()));
  }

  public static function put() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id') || !Request::getInstance()->hasData('state')) {
      Response::getInstance()->sendStatus(400);
    }

    if (Request::getInstance()->getParam('id') == RoleProvider::ADMIN_ID) {
      Response::getInstance()->sendStatus(406);
    }

    $roles = RoleProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($roles) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $roles[0]->setState(Request::getInstance()->getData('state'));

    $succes = RoleProvider::edit($roles[0]);

    Response::getInstance()->sendStatus($succes ? 200 : 500);
  }
};
