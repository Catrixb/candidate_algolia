<?php

namespace App;

class Query implements \JsonSerializable
{
  private $query;
  private $count;

  public function __construct(int $count, string $query) {
    $this->count = $count;
    $this->query = trim($query);
  }

  public function jsonSerialize() {
    return [
      'query' => $this->query,
      'count' => $this->count
    ];
  }
}