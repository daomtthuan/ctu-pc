<?php

namespace Plugin;

use DOMElement;
use PHPMailer\PHPMailer\PHPMailer;

/** Mail plugin */
class MailPlugin {
  private static MailPlugin $instance;
  private PHPMailer $mailer;

  /** 
   * Create new instance of MailPlugin
   */
  private function __construct() {
    $this->mailer = new PHPMailer(true);
    $this->mailer->isSMTP();
    $this->mailer->SMTPAuth = true;
    $this->mailer->Host = $_ENV['MAIL_HOST'];
    $this->mailer->Port = $_ENV['MAIL_PORT'];
    $this->mailer->SMTPSecure = $_ENV['MAIL_SECURE'];
    $this->mailer->Username = $_ENV['MAIL_USERNAME'];
    $this->mailer->Password = $_ENV['MAIL_PASSWORD'];
    $this->mailer->setLanguage('vi');
    $this->mailer->CharSet = 'utf-8';
    $this->mailer->Encoding = 'base64';
    $this->mailer->setFrom($_ENV['MAIL_USERNAME'], $_ENV['MAIL_NAME']);
  }

  /** 
   * Get instance of MailPlugin 
   * 
   * @return MailPlugin MailPlugin
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new MailPlugin();
    }
    return self::$instance;
  }

  /**
   * Send HTML mail
   * 
   * @param string $email Email receiver
   * @param string $name Name receiver
   * @param string $subject Subject mail
   * @param DOMElement $body HTML body mail
   */
  public function sendHtml(string $email, string $name, string $subject, DOMElement $body) {
    $this->mailer->clearAddresses();
    $this->mailer->addAddress($email, $name);
    $this->mailer->isHTML();
    $this->mailer->Subject = $subject;
    $this->mailer->Body = $body->ownerDocument->saveHTML($body);
    $this->mailer->send();
  }
}
