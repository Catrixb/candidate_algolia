<?php

namespace App;

class Query implements \JsonSerializable, \Countable
{
  private $query;
  private $count;

  public function __construct(int $count, string $query = '') {
    $this->count = $count;
    $this->query = trim($query);
  }

  public function jsonSerialize() {
    $query = [];

    if ($this->query) {
      $query['query'] = $this->query;
    }

    $query['count'] = $this->count;

    return $query;
  }

  /**
   * @return int
   */
  public function count(): int {
    return $this->count;
  }
}