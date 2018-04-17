<?php

namespace App;

class DateRangeHelper
{
  const FORMAT_REGEX = '~([0-9]{4})(?:-(\d{2}))?(?:-(\d{2}))?(?: (\d{2}):(\d{2}))?~';
  const MAX_DEPTH = 3;

  private $date;
  private $dates = [];

  public function __construct(string $date) {
    $this->date = urldecode($date);
    preg_match(self::FORMAT_REGEX, $this->date, $this->dates);
    array_shift($this->dates);
  }

  public function cut($depth = self::MAX_DEPTH) {
    $date = $this->dates;
    array_splice($date, $depth);

    return join('-', $date);
  }

  public function year() {
    return $this->dates[0];
  }

  public function __toString() {
    return $this->date;
  }
}