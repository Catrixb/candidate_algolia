<?php

namespace App;

class QueryFileReducer implements FileReducer
{
  private $config;

  public function __construct(Config $config) {
    $this->config = $config;
  }

  public function reduce(string $date) {
    $dateRangeHelper = new DateRangeHelper($date);

    $from = new \SplFileInfo(
      $this->config->getFullPath($dateRangeHelper->year())
    );

    $to = new \SplFileInfo(
      $this->config->getFullPath($dateRangeHelper->cut())
    );

    if (!$to->isFile()) {
      QueryFactory::reduce($from, $to, $date);

      return $to;
    }

    return $from;
  }

  public function clean(string $date) {
    $dateRangeHelper = new DateRangeHelper($date);

    array_map('unlink', glob(
      $this->config->getFullPath($dateRangeHelper->year().'-*')
    ));
  }
}