<?php

namespace App\Cache;

use App\Config;
use League\Flysystem\FilesystemInterface;
use Psr\SimpleCache\CacheInterface;

class FileCache implements CacheInterface
{
  private $fileSystem;
  private $config;

  public function __construct(FilesystemInterface $filesystem, Config $config) {
    $this->config = $config;
    $this->fileSystem = $filesystem;
  }

  private function sanitizeKey($key) {
    return str_replace('\\', '-', $key) . '.cache';
  }

  public function get($key, $default = null) {
    if ($this->has($key)) {
      return unserialize($this->fileSystem->read($this->sanitizeKey($key)));
    }

    return null;
  }

  public function set($key, $value, $ttl = null) {
    return $this->fileSystem->put($this->sanitizeKey($key), serialize($value));
  }

  public function delete($key) {
    return array_map('unlink', glob($this->config->get('file.query.cache') . $key . '-*'));
  }

  /**
   * Wipes clean the entire cache's keys.
   *
   * @return bool True on success and false on failure.
   */
  public function clear() {
    return $this->fileSystem->deleteDir('./');
  }

  /**
   * @inheritdoc
   */
  public function getMultiple($keys, $default = null) {
    // TODO: Implement getMultiple() method.
  }

  /**
   * @inheritdoc
   */
  public function setMultiple($values, $ttl = null) {
    // TODO: Implement setMultiple() method.
  }

  /**
   * @inheritdoc
   */
  public function deleteMultiple($keys) {
    // TODO: Implement deleteMultiple() method.
  }

  /**
   * @inheritdoc
   */
  public function has($key) {
    return $this->fileSystem->has($this->sanitizeKey($key));
  }
}