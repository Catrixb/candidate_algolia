<?php

namespace App;

use App\Commands\ShellCommand;
use App\Commands\ShellCommandToFile;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class QueryFileReducer
{
  const REDUCE_BY_YEAR = 1;
  const REDUCE_BY_MONTH = 2;
  const REDUCE_BY_DAY = 3;

  private $rootPath;
  private $fileName;
  private $fileExtension;

  public function __construct($rootPath) {
    $this->rootPath = $rootPath;
    $this->fileName = config('app.file.query.name');
    $this->fileExtension = config('app.file.query.extension');

    $adapter = new Local($rootPath);
    $this->fileSystem = new Filesystem($adapter);
  }

  public function reduce(string $dateRange) {
    $date = preg_replace('~\s.*~', '', $dateRange);
    $dates = explode('-', $date);
    $depth = count($dates);

    $yearPath = $this->fileName . "-$dates[0]" . $this->fileExtension;
    $file = new \SplFileInfo($this->rootPath . $yearPath);

    if ($depth === self::REDUCE_BY_YEAR) {
      return $file;
    }

    if ($depth === self::REDUCE_BY_MONTH) {
      $path = $this->fileName . "-$dates[0]-$dates[1]";
    } elseif ($depth === self::REDUCE_BY_DAY) {
      $path = $this->fileName . "-$dates[0]-$dates[1]-$dates[2]";
    }

    $file = $this->reduceFile($path, $date, $file);
    
    if (!$file->isExecutable()) {
      chmod($file->getRealPath(), octdec(755));
    }

    return $file;
  }

  private function reduceFile($path, $date, $file) {
    $fullPath = $this->rootPath . $path . $this->fileExtension;

    if (!$this->fileSystem->has($path . $this->fileExtension)) {
      $this->fileSystem->write($path . $this->fileExtension, '');

      $commandToFile = new ShellCommandToFile(
        new ShellCommand($date, $file),
        $fullPath
      );

      $commandToFile->execute();
      
      return new \SplFileInfo($fullPath);
    }

    return $file;
  }
}