<?php

namespace App\Commands;

use Symfony\Component\Process\Process;

abstract class QueryCommand
{
  protected $process;
  protected $command;

  public function __construct(ShellCommand $command) {
    $this->command = $command;
    $this->process = new Process("");
  }

  public function execute() {
    $this->process
      ->setCommandLine((string) $this->command)
      ->run();

    if (!$this->process->isSuccessful()) {
      // @TODO Log error
      return null;
    }

    return $this->process->getOutput();
  }
}