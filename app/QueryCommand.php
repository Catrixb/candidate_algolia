<?php

namespace App;

use Symfony\Component\Process\Process;

/**
 * It finds the number of distinct queries that have been done during
 * $this->dateRange time range
 */
abstract class QueryCommand
{
  protected $process;

  public function __construct(ShellCommand $command) {
    $this->command = $command;
    $this->process = new Process("");
  }

  public function execute() {
    $this->process
      ->setCommandLine((string) $this->command)
      ->mustRun();

    return $this->process->getOutput();
  }
}