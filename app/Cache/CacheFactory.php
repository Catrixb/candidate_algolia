<?php

namespace App\Cache;

use App\Exceptions\CacheNotImplementedException;

class CacheFactory
{
  const APC = 'apc';
  const FILE = 'file';

  private function __construct() {
  }

  static public function getCache(string $cache = self::FILE) {
    switch ($cache) {
      case self::APC:
        if (extension_loaded('apc')) {
          return new ApcCache();
        } else {
          throw new CacheNotImplementedException();
        }
        break;
      case self::FILE:
      default:
        return new FileCache();
        break;
    }
  }
}