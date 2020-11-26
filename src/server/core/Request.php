<?php

namespace Core;

use Entity\Account;
use Provider\AccountProvider;
use Provider\RoleProvider;

/** Request */
class Request {
  private static Request $instance;
  private array $address;
  private string $url;
  private array $cookies;
  private array $params;
  private string $method;
  private array $data;
  private array $files;

  /** Create new instance of Request */
  private function __construct() {
    // Get Address request
    $this->address = [
      'ip' => $_SERVER['REMOTE_ADDR'],
      'mac' => strtok(exec('getmac'), ' ')
    ];

    // Get reques url 
    $this->url = strtok(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/', '?');

    // Get cookies
    $this->cookies = $_COOKIE;

    // Get request params
    $this->params = $_GET;

    // Get reques method 
    $this->method = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD'])  : 'get';

    // Get request data
    if (isset($_SERVER['CONTENT_TYPE'])) {
      if (strpos(strtolower($_SERVER['CONTENT_TYPE']), 'application/json') !== false) {
        $this->data = json_decode(file_get_contents('php://input'), true);
      } else if (strpos(strtolower($_SERVER['CONTENT_TYPE']), 'multipart/form-data') !== false) {
        // Get input data
        $rawData = file_get_contents('php://input');
        $boundary = substr($rawData, 0, strpos($rawData, "\r\n"));

        // Analyze input data -> each part
        $this->data = [];
        foreach (array_slice(explode($boundary, $rawData), 1) as $part) {
          if ($part == "--\r\n") break;

          $part = ltrim($part, "\r\n");

          // Analyze part -> headers, body
          list($rawHeaders, $body) = explode("\r\n\r\n", $part, 2);

          $headers = [];
          foreach (explode("\r\n", $rawHeaders) as $header) {
            // Analyze header -> headers, body
            list($name, $value) = explode(':', $header);
            $headers[strtolower($name)] = ltrim($value, ' ');
          }

          // Analyze data -> File or data
          if (isset($headers['content-disposition'])) {
            preg_match(
              '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
              $headers['content-disposition'],
              $matches
            );
            $name = $matches[2];

            if (isset($matches[4])) { // If file
              // if files was added, skip
              if (isset($_FILES[$name])) {
                continue;
              }

              $filename = $matches[4];
              $filename_parts = pathinfo($filename);
              $tmp_name = tempnam(ini_get('upload_tmp_dir'), $filename_parts['filename']);

              // Add file to uploaded files
              $_FILES[$name] = [
                'error' => 0,
                'name' => $filename,
                'tmp_name' => $tmp_name,
                'size' => strlen($body),
                'type' => $value
              ];
              file_put_contents($tmp_name, $body);
            } else { // if data
              $this->data[$name] = substr($body, 0, strlen($body) - 2);
            }
          }
        }
      } else {
        // Get data form
        $this->data = $_POST;
      }
    }

    // Get upload files
    $this->file = $_FILES;
  }

  /** 
   * Get instance of Request 
   * 
   * @return Request Request
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new Request();
    }
    return self::$instance;
  }

  /**
   * Get Address request
   * 
   * @param string|null $key Param Key
   * 
   * @return array|mixed Get All params. Otherwise, value of param has that key
   */
  public function getAddress(string $key = null) {
    if (!isset($key)) {
      return $this->address;
    } else {
      return $this->address[$key];
    }
  }

  /**
   * Get the value of url request
   */
  public function getUrl() {
    return $this->url;
  }

  /**
   * Get Cookie request
   * 
   * @param string|null $key Cookie Key
   * 
   * @return mixed Cookies if $key is null. Otherwise, value of Cookie has that key
   */
  public function getCookie(string $key = null) {
    if (!isset($key)) {
      return $this->cookies;
    } else {
      return $this->cookies[str_replace('.', '_', $key)];
    }
  }

  /**
   * Check request has cookie or not
   * 
   * @param string[] $keys Cookie Keys
   * 
   * @return bool true if has cookie. Otherwise, false.
   */
  public function hasCookie(string ...$keys) {
    if (!isset($this->cookies)) {
      return false;
    }

    if (count($keys) == 0) {
      return count($this->cookies) > 0;
    } else {
      foreach ($keys as $key) {
        if (!isset($this->cookies[str_replace('.', '_', $key)])) {
          return false;
        }
      }
      return true;
    }
  }

  /**
   * Get the value of method
   */
  public function getMethod() {
    return $this->method;
  }

  /**
   * Get data request
   * 
   * @param string|null $key Data Key
   * 
   * @return mixed Data JSON object if $key is null. Otherwise, value of data has that key
   */
  public function getData(string $key = null) {
    if (!isset($key)) {
      return $this->data;
    } else {
      return $this->data[$key];
    }
  }

  /**
   * Check request has data or not
   * 
   * @param string[] $keys Data Keys
   * 
   * @return bool true if has data. Otherwise, false.
   */
  public function hasData(string ...$keys) {
    if (!isset($this->data)) {
      return false;
    }

    if (count($keys) == 0) {
      return count($this->data) > 0;
    } else {
      foreach ($keys as $key) {
        if (!isset($this->data[$key])) {
          return false;
        }
      }
      return true;
    }
  }

  /**
   * Get params request
   * 
   * @param string|null $key Param Key
   * 
   * @return array|mixed Get All params. Otherwise, value of param has that key
   */
  public function getParam(string $key = null) {
    if (!isset($key)) {
      return $this->params;
    } else {
      return $this->params[$key];
    }
  }

  /**
   * Check request has paramater or not
   * 
   * @param string[] $keys paramater Keys
   * 
   * @return bool true if has paramater. Otherwise, false.
   */
  public function hasParam(string ...$keys) {
    if (!isset($this->params)) {
      return false;
    }

    if (count($keys) == 0) {
      return count($this->params) > 0;
    } else {
      foreach ($keys as $key) {
        if (!isset($this->params[$key])) {
          return false;
        }
      }
      return true;
    }
  }

  /**
   * Get files request
   * 
   * @param string|null $key Data Key
   * 
   * @return mixed Files if $key is null. Otherwise, value of file has that key
   */
  public function getFile(string $key = null) {
    if (!isset($key)) {
      return $this->files;
    } else {
      return $this->files[$key];
    }
  }

  /**
   * Check request has file or not
   * 
   * @param string[] $keys Data Keys
   * 
   * @return bool true if has file. Otherwise, false.
   */
  public function hasFile(string ...$keys) {
    if (!isset($this->files)) {
      return false;
    }

    if (count($keys) == 0) {
      return count($this->files) > 0;
    } else {
      foreach ($keys as $key) {
        if (!isset($this->files[$key])) {
          return false;
        }
      }
      return true;
    }
  }

  /**
   * Verify account
   * 
   * @return Account Verified account
   */
  public function verifyAccount() {
    if (!$this->hasCookie($_ENV['TOKEN_KEY_LOCAL'])) {
      Response::getInstance()->sendStatus(401);
    }

    Session::start($this->getCookie($_ENV['TOKEN_KEY_LOCAL']));
    if (!Session::has('account')) {
      Response::getInstance()->sendStatus(401);
    }

    /** @var Account */
    $accountSession = Session::get('account');
    $accounts = AccountProvider::find([
      'id' => $accountSession->getId()
    ]);

    if (count($accounts) != 1) {
      Response::getInstance()->sendStatus(401);
    }

    if (!$accounts[0]->getState()) {
      Response::getInstance()->sendStatus(406);
    }

    return $accounts[0];
  }

  /**
   * Verify admin account
   * 
   * @return Account Verified admin account
   */
  public function verifyAdminAccount() {
    $account = $this->verifyAccount();
    $roles = RoleProvider::findOwnedByAccount($account->getId(), [
      'id' => RoleProvider::ADMIN_ID,
      'state' => 1
    ]);
    if (count($roles) == 0) {
      Response::getInstance()->sendStatus(404);
    }
    return $account;
  }
}
