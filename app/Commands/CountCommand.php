<?php

namespace App\Commands;

/**
 * It finds the number of distinct queries that have been done during
 * a specific time range
 */
class CountCommand extends QueryCommand
{
  public function execute(): int {
    $this->command
      ->selectColumn(2)
      ->sort()
      ->uniq()
      ->countLines()
      ->trim()
      ->removeNewLines();

    return parent::execute();
  }
}