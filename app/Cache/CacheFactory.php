<?php

namespace App\Cache;

use App\Config;
use App\Exceptions\CacheNotImplementedException;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

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
        $config = Config::self();
        $adapter = new Local($config->get('file.query.cache'));
        $fileSystem = new Filesystem($adapter);

        return new FileCache($fileSystem, $config);
        break;
    }
  }
}