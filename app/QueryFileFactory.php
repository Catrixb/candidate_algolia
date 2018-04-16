<?php

namespace App;

use League\Flysystem\Adapter\Local;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;

class QueryFileFactory
{
  static private $localQueryPath = 'app/queries/';
  static private $fileName = 'hn_logs.tsv.gz';

  static public function getFileInfo(string $date) {
    $file = new \SplFileInfo(static::buildPath($date));

    if (!$file->isExecutable()) {
      chmod($file->getRealPath()  , octdec(755));
    }

    return $file;
  }

  static private function buildPath(string $date) {
    $dates = explode('-', $date);

    $path = storage_path(static::$localQueryPath);
    $adapter = new Local($path);
    $fileSystem = new Filesystem($adapter);

    $yearPath = $dates[0] . '/' . static::$fileName;

    if (!$fileSystem->has($yearPath)) {
      throw new FileNotFoundException($yearPath);
    }

    return $path . $yearPath;
  }
}