<?php

namespace App;

class Query implements \JsonSerializable
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
  public function getCount(): int {
    return $this->count;
  }

  /**
   * @return string
   */
  public function getQuery(): string {
    return $this->query;
  }
}