<?php

namespace App\Cache;

use App\Config;
use App\DateRangeHelper;
use App\Exceptions\RootQueryFileNotFoundException;
use App\FileReducer;
use App\Query;
use App\QueryCollection;
use App\QueryFactory;
use App\QueryFile;
use App\QueryFileFactory;
use Psr\SimpleCache\CacheInterface;

class QueryFactoryCache
{
  public function __construct(CacheInterface $cache, Config $config, FileReducer $reducer) {
    $this->cache = $cache;
    $this->config = $config;
    $this->reducer = $reducer;
  }

  public function count(string $date): Query {
    try {
      $this->refreshCacheIfModified($date);

      $cacheKey = $date . '-' . __METHOD__;
      if ($cache = $this->cache->get($cacheKey)) {
        return $cache;
      }

      $query = QueryFactory::count($this->reducer->reduce($date), $date);

      $this->cache->set($cacheKey, $query);
    } catch (RootQueryFileNotFoundException $e) {
      $query = new Query(0);
    }

    return $query;
  }

  public function popular(string $date, int $size): QueryCollection {
    try {
      $this->refreshCacheIfModified($date);

      $cacheKey = $date . '-' . __METHOD__ . '-' . $size;
      if ($cache = $this->cache->get($cacheKey)) {
        return $cache;
      }

      $collection = QueryFactory::popular(
        $this->reducer->reduce($date),
        $date,
        $size
      );

      $this->cache->set($cacheKey, $collection);
    } catch (RootQueryFileNotFoundException $e) {
      $collection = new QueryCollection();
    }

    return $collection;
  }

  private function refreshCacheIfModified(string $date) {
    $date = new DateRangeHelper($date);
    $year = $date->year();

    $lastModifiedInCache = $this->cache->get($year);

    $file = new \SplFileInfo($this->config->getFullPath($year));

    if (!$file->isFile()) {
      throw new RootQueryFileNotFoundException("No file found for the date $date");
    }

    $lastModified = $file->getMTime();

    if (empty($lastModifiedInCache)) {
      $this->cache->set($year, $lastModified);
    } else if ($lastModified !== $lastModifiedInCache) {
      $this->cache->delete($year);
      $this->reducer->clean($date);
      $this->cache->set($year, $lastModified);
    }
  }
}