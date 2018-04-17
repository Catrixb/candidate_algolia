<?php

namespace App;

class QueryFileFactory
{
  /*
   * @TODO extract to event
   */
  static public function removeFileReduced(string $date) {
    $date = preg_replace('~\s.*~', '', $date);
    $dates = explode('-', $date);

    array_map('unlink', glob(
      Config::get("file.query.storagePath") .
      Config::get("file.query.name") .
      "-$dates[0]-*" .
      Config::get("file.query.extension")
    ));
  }

  static public function getFileInfo(string $date) {
    $reducer = new QueryFileReducer(Config::get("file.query.storagePath"));

    return $reducer->reduce($date);
  }
}