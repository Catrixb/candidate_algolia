<?php

namespace App\Commands;

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

  public function execute(): string {
    $this->command
      ->selectColumn(2)
      ->sort()
      ->countUniq()
      ->reverseSort()
      ->limit($this->size)
      ->trim();

    if (empty($query = parent::execute())) {
      return "";
    }

    return $query;
  }
}