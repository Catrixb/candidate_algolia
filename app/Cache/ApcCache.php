<?php

namespace App\Cache;

use APCIterator;
use Psr\SimpleCache\CacheInterface;

class ApcCache implements CacheInterface
{
  const TTL = 360;

  public function get($key, $default = null) {
    if ($this->has($key)) {
      return apc_fetch($key);
    }

    return null;
  }

  public function set($key, $value, $ttl = null) {
    return apc_store($key, $value, $ttl ?: self::TTL);
  }

  public function delete($key) {
    return apc_delete(
      new APCIterator('user', "/^$key-/", APC_ITER_ALL)
    );
  }

  /**
   * Wipes clean the entire cache's keys.
   *
   * @return bool True on success and false on failure.
   */
  public function clear() {
    return apc_clear_cache();
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
    return apc_exists($key);
  }
}