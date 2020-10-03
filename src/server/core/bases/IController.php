<?php

namespace Core\Bases;

interface IController {
  /**
   * Map Request URL
   * 
   * @return string URL mapping
   */
  public static function mapUrl();
}
