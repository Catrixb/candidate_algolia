<?php

namespace App;

class Config
{
  static private $config;

  private function __construct() {}

  static public function self() {
    if (isset(self::$config)) {
      return self::$config;
    }

    return self::$config = new self();
  }

  public function get($key, $default = null) {
    if (app()->environment() === 'testing') {
      return config('test.' . $key, $default);
    }

    return config('app.' . $key, $default);
  }

  public function getFullPath(string $appendToName = '') {
    return
      static::get('file.query.path') .
      static::get('file.query.name') .
      ($appendToName ? "-$appendToName" : "") .
      static::get('file.query.extension');
  }
}