<?php

namespace App;

class QueryFileFactory
{
  /*
   * @TODO extract to event
   */
  static public function removeFileReduced(DateRangeHelper $date) {
    array_map('unlink', glob(
      Config::get("file.query.path") .
      Config::get("file.query.name") .
      "-{$date->year()}-*" .
      Config::get("file.query.extension")
    ));
  }

  static public function getFileInfo(DateRangeHelper $date) {
    $reducer = new QueryFileReducer(Config::get("file.query.path"));

    return $reducer->reduce($date);
  }
}