<?php

namespace App;

class QueryCollection
{
  public function __construct($queries = []) {
    $this->queries = $queries;
  }

  public function toArray() {
    return ['queries' => $this->queries];
  }
}