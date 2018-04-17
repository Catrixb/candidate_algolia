<?php

namespace App\Cache;

use App\Query;
use App\QueryCollection;
use App\QueryFactory;
use App\QueryFileFactory;
use Psr\SimpleCache\CacheInterface;

class QueryFactoryCache
{
  public function __construct(CacheInterface $cache) {
    $this->cache = $cache;
  }

  public function count(string $dateRange): Query {
    $file = $this->refreshCache($dateRange);

    $cacheKey = $dateRange . '-' . __METHOD__;
    if ($cache = $this->cache->get($cacheKey)) {
      return $cache;
    }

    $query = QueryFactory::count($file, $dateRange);

    $this->cache->set($cacheKey, $query);

    return $query;
  }

  public function popular(string $dateRange, int $size): QueryCollection {
    $file = $this->refreshCache($dateRange);

    $cacheKey = $dateRange . '-' . __METHOD__ . '-' . $size;
    if ($cache = $this->cache->get($cacheKey)) {
      return $cache;
    }

    $collection = QueryFactory::popular($file, $dateRange, $size);

    $this->cache->set($cacheKey, $collection);

    return $collection;
  }

  // TODO event
  private function refreshCache($dateRange): \SplFileInfo {
    $dates = explode('-', $dateRange);
    $year = $dates[0];

    $lastModifiedInCache = $this->cache->get($year);

    $file = QueryFileFactory::getFileInfo($year);

    $lastModified = $file->getMTime();
    if (empty($lastModifiedInCache)) {
      $this->cache->set($year, $lastModified);
    } else if ($lastModified !== $lastModifiedInCache) {
      $this->cache->delete($year);
      QueryFileFactory::removeFileReduced($year);
      $this->cache->set($year, $lastModified);
    }

    // Generate the file for this dateRAnge
    return QueryFileFactory::getFileInfo($dateRange);
  }
}