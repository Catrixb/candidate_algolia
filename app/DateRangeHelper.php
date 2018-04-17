<?php

namespace App;

class DateRangeHelper implements \Countable
{
  const FORMAT_REGEX = '~([0-9]{4})(?:-(\d{2}))?(?:-(\d{2}))?(?: (\d{2}):(\d{2}))?~';
  private $dates = [];
  private $dateRange;

  public function __construct(string $dateRange) {
    $this->dateRange = urldecode($dateRange);
    preg_match(self::FORMAT_REGEX, $dateRange, $this->dates);
  }

  public function year() {
    return $this->dates[1];
  }

  public function month() {
    return $this->dates[2] ?? null;
  }

  public function day() {
    return $this->dates[3] ?? null;
  }

  public function __toString() {
    return $this->dateRange;
  }

  /**
   * @inherit
   */
  public function count() {
    return count($this->dates) - 1;
  }
}