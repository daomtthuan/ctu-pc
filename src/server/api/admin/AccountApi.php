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

/** Admin account api */
class AccountApi extends Api {
  public static function mapUrl() {
    return '/api/admin/account';
  }

  public static function get() {
    Request::getInstance()->verifyAdminAccount();

    $accounts = [];
    foreach (AccountProvider::find(Request::getInstance()->getParam()) as $account) {
      $data = $account->jsonSerialize();
      unset($data['password']);
      $accounts[] = $data;
    }
    Response::getInstance()->sendJson($accounts);
  }

  public static function post() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasData('username', 'email', 'fullName', 'birthday', 'gender', 'phone', 'address')) {
      Response::getInstance()->sendStatus(400);
    }

    $accounts = AccountProvider::find([
      'username' => Request::getInstance()->getData('username')
    ]);
    if (count($accounts) != 0) {
      Response::getInstance()->sendStatus(406);
    }

    $success = Database::getInstance()->doTransaction(function () {
      $randomPassword = StringPlugin::generateRandomString(10);

      $idAccount = AccountProvider::create(new Account([
        'id' => null,
        'username' => Request::getInstance()->getData('username'),
        'password' => password_hash($randomPassword, PASSWORD_BCRYPT),
        'fullName' => Request::getInstance()->getData('fullName'),
        'birthday' => Request::getInstance()->getData('birthday'),
        'gender' => Request::getInstance()->getData('gender'),
        'email' => Request::getInstance()->getData('email'),
        'address' => Request::getInstance()->getData('address'),
        'phone' => Request::getInstance()->getData('phone'),
        'state' => null
      ]));

      PermissionProvider::create(new Permission([
        'id' => null,
        'idAccount' => $idAccount,
        'idRole' => RoleProvider::USER_ID,
        'state' => null
      ]));

      $h1 = fn ($name) => HtmlPlugin::getInstance()->createElement($name);
      $h2 = fn ($name, $content) => HtmlPlugin::getInstance()->createElement($name, $content);
      $h3 = fn ($name, $properties) => HtmlPlugin::getInstance()->createElement($name, null, $properties);

      MailPlugin::getInstance()->sendHtml(
        Request::getInstance()->getData('email'),
        Request::getInstance()->getData('fullName'),
        'Đăng ký tài khoản CTU PC SHOP',
        $h2('div', [
          $h2('p', [
            $h2('span', 'Xin chào '),
            $h2('strong', Request::getInstance()->getData('fullName')),
            $h2('span', ','),
            $h1('br'),
            $h2('span', 'Quá trình tạo tài khoản đã thành công. Chào mừng bạn đến với CTU PC SHOP!'),
            $h1('br'),
            $h2('span', 'Giờ đây, bạn có thể sử dụng tài khoản sau để đăng nhập:'),
          ]),
          $h2('form', [
            $h2('label', 'Tên đăng nhập:', ['for' => 'username']),
            $h1('br'),
            $h3('input', ['id' => 'username', 'value' =>  Request::getInstance()->getData('username')]),
            $h1('br'),
            $h2('label', 'Mật khẩu:', ['for' => 'password']),
            $h1('br'),
            $h3('input', ['id' => 'password', 'value' => $randomPassword]),
          ]),
          $h2('p', 'Trân trọng'),
          $h1('hr'),
          $h2('p', [
            $h2('em', [
              $h2('strong', 'Lưu ý: '),
              $h2('span', 'Vui lòng đổi mật khẩu ngay vào lần truy cập đầu tiên và tuyệt đối không để cho ai biêt được thông tin tài khoản.'),
              $h1('br'),
              $h2('span', 'Đây là email tự động, không trả lời vào email này.'),
            ])
          ]),
        ])
      );
    });

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }

  public static function put() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id') || !Request::getInstance()->hasData('email', 'fullName', 'birthday', 'gender', 'phone', 'address', 'state')) {
      Response::getInstance()->sendStatus(400);
    }

    $accounts = AccountProvider::find([
      'id' => Request::getInstance()->getParam('id')
    ]);
    if (count($accounts) != 1) {
      Response::getInstance()->sendStatus(404);
    }

    $accounts[0]->setEmail(Request::getInstance()->getData('email'));
    $accounts[0]->setFullName(Request::getInstance()->getData('fullName'));
    $accounts[0]->setBirthday(Request::getInstance()->getData('birthday'));
    $accounts[0]->setGender(Request::getInstance()->getData('gender'));
    $accounts[0]->setPhone(Request::getInstance()->getData('phone'));
    $accounts[0]->setAddress(Request::getInstance()->getData('address'));
    $accounts[0]->setState(Request::getInstance()->getData('state'));

    AccountProvider::edit($accounts[0]);
    Response::getInstance()->sendStatus(200);
  }

  public static function delete() {
    Request::getInstance()->verifyAdminAccount();

    if (!Request::getInstance()->hasParam('id')) {
      Response::getInstance()->sendStatus(400);
    }

    $success = Database::getInstance()->doTransaction(function () {
      $id = Request::getInstance()->getParam('id');

      // TODO: Remove review of Account
      // TODO: Remove event post of Account

      PermissionProvider::remove(['idAccount' => $id]);
      AccountProvider::remove(['id' => $id]);
    });

    Response::getInstance()->sendStatus($success ? 200 : 500);
  }
};
