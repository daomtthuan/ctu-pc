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
    foreach (AccountProvider::find() as $account) {
      $data = $account->getData();
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

    Database::getInstance()->doTransaction(function () {
      $randomPassword = StringPlugin::generateRandomString(10);

      AccountProvider::create(new Account([
        'username' => Request::getInstance()->getData('username'),
        'password' => password_hash($randomPassword, PASSWORD_BCRYPT),
        'fullName' => Request::getInstance()->getData('fullName'),
        'birthday' => Request::getInstance()->getData('birthday'),
        'gender' => Request::getInstance()->getData('gender'),
        'email' => Request::getInstance()->getData('email'),
        'address' => Request::getInstance()->getData('address'),
        'phone' => Request::getInstance()->getData('phone'),
      ]));

      PermissionProvider::create(new Permission([
        'idAccount' => Database::getInstance()->getLastInsertedId(),
        'idRole' => RoleProvider::USER_ID
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
  }
};
