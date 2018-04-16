<?php

namespace App\Commands;

use App\Query;

/**
 * It finds the top $this->size queries that have been done during
 * a specif time range
 */
class PopularCommand extends QueryCommand
{
  private $size;

  public function __construct(ShellCommand $command, int $size) {
    $this->size = $size;
    parent::__construct($command);
  }

  public function execute(): array {
    $this->command
      ->selectColumn(2)
      ->sort()
      ->countUniq()
      ->reverseSort()
      ->limit($this->size)
      ->trim();

    if (empty($query = parent::execute())) {
      return [];
    }

    return $this->parse($query);
  }

  private function parse(string $rawQuery): array {
    $queries = explode("\n", $rawQuery, $this->size);

    $queries = collect($queries)->map(function($q) {
      list($count, $query) = explode(" ", $q);

      return new Query($count, $query);
    });

    return $queries->toArray();
  }
}