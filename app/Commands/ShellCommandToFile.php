<?php

namespace App\Commands;

class ShellCommandToFile extends QueryCommand
{
  private $to;

  public function __construct(ShellCommand $command, string $to) {
    $this->to = $to;

    parent::__construct($command);
  }

  public function execute() {
    $this->command = (string) $this->command . ' > ' . $this->to;

    return parent::execute();
  }
}