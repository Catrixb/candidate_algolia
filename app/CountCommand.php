<?php

namespace App;

use Symfony\Component\Process\Process;

/**
 * It finds the number of distinct queries that have been done during
 * $this->dateRange time range
 */
class CountCommand
{
  private $process;

  public function __construct(ShellCommand $command)
  {
    $this->command = $command;
    $this->process = new Process("");
  }

  public function execute(): int
  {
    $this->command
      ->selectColumn(2)
      ->sort()
      ->uniq()
      ->countLines()
      ->trim()
      ->removeNewLines();

    $process = $this->process
      ->setCommandLine((string) $this->command)
      ->mustRun();

    return $process->getOutput();
  }
}