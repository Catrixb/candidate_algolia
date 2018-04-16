<?php

namespace App;

use Symfony\Component\Process\Process;

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