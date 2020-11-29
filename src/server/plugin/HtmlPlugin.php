<?php

namespace Plugin;

use DOMDocument;
use DOMElement;

/** HTML plugin */
class HtmlPlugin {
  private static HtmlPlugin $instance;
  private DOMDocument $dom;

  /** 
   * Create new instance of HtmlPlugin
   */
  private function __construct() {
    $this->dom = new DOMDocument();
  }

  /** 
   * Get instance of HtmlPlugin 
   * 
   * @return HtmlPlugin HtmlPlugin
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new HtmlPlugin();
    }
    return self::$instance;
  }

  /**
   * Create html dom element
   * 
   * @param string $name Name element
   * @param DOMElement[]|string|null $content Elements or string content
   * @param string[string] $properties Properties element
   */
  public function createElement(string $name, $content = null, array $properties = null) {
    $root = $this->dom->createElement($name);

    if (isset($content)) {
      if (is_string($content)) {
        $root->nodeValue =  $content;
      } else {
        foreach ($content as $element) {
          $root->appendChild($element);
        }
      }
    }

    if (isset($properties)) {
      foreach ($properties as $key => $value) {
        $root->setAttribute($key, $value);
      }
    }

    return $root;
  }
}
