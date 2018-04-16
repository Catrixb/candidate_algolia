<?php

namespace App\Commands;

class ShellCommand
{
  private $command = [];

  public function __construct($find, \SplFileInfo $file) {
    $grep = $file->getExtension() === 'gz' ? 'zgrep' : "grep";

    // Use LC_ALL=C to change the locale for better grep performances
    $this->command[] = "LC_ALL=C $grep '^$find' {$file->getRealPath()}";

    return $this;
  }

  public function selectColumn(int $column) {
    $this->command[] = "cut -f$column";

    return $this;
  }

  public function sort() {
    $this->command[] = 'sort';

    return $this;
  }

  public function reverseSort() {
    $this->command[] = 'sort -r';

    return $this;
  }

  public function uniq() {
    $this->command[] .= 'uniq';

    return $this;
  }

  public function countUniq() {
    $this->command[] .= 'uniq -c';

    return $this;
  }

  public function countLines() {
    $this->command[] = 'wc -l';

    return $this;
  }

  public function trim() {
    $this->command[] = "sed -e 's/^ *//;s/ / /'";

    return $this;
  }

  public function removeNewLines() {
    $this->command[] = "tr -d '\n'";

    return $this;
  }

  public function limit(int $limit) {
    $this->command[] = "head -$limit";

    return $this;
  }

  public function __toString() {
    return join(' | ', $this->command);
  }
}