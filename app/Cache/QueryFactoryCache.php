<?php

namespace App\Cache;

use App\DateRangeHelper;
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

  public function count(DateRangeHelper $dateRange): Query {
    $file = $this->refreshCache($dateRange);

    $cacheKey = $dateRange . '-' . __METHOD__;
    if ($cache = $this->cache->get($cacheKey)) {
      return $cache;
    }

    $query = QueryFactory::count($file, $dateRange);

    $this->cache->set($cacheKey, $query);

    return $query;
  }

  public function popular(DateRangeHelper $dateRange, int $size): QueryCollection {
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
  private function refreshCache(DateRangeHelper $dateRange): \SplFileInfo {
    $lastModifiedInCache = $this->cache->get($dateRange->year());

    $file = QueryFileFactory::getFileInfo($dateRange);

    $lastModified = $file->getMTime();
    if (empty($lastModifiedInCache)) {
      $this->cache->set($dateRange->year(), $lastModified);
    } else if ($lastModified !== $lastModifiedInCache) {
      $this->cache->delete($dateRange->year());
      QueryFileFactory::removeFileReduced($dateRange);
      $this->cache->set($dateRange->year(), $lastModified);
    }

    // Generate the file for this dateRAnge
    return QueryFileFactory::getFileInfo($dateRange);
  }
}