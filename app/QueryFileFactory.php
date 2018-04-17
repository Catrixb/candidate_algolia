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
      storage_path(config("app.file.query.path")) .
      config("app.file.query.name") .
      "-$dates[0]-*" .
      config("app.file.query.extension")
    ));
  }

  static public function getFileInfo(string $date, $path = '') {
    $reducer = new QueryFileReducer(
      empty($path) ? storage_path(config("app.file.query.path")) : $path
    );

    return $reducer->reduce($date);
  }
}