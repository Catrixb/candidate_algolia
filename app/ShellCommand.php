<?php
namespace App;


class ShellCommand
{
  private $command = [];

  public function __construct($find, $path) {
    $file = new \SplFileInfo($path);
    
    $grep = $file->getExtension() === 'gz' ? 'zgrep' : "grep";

    $this->command[] = "$grep '^$find' $path";

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

  public function uniq() {
    $this->command[] = 'uniq';

    return $this;
  }

  public function countLines() {
    $this->command[] = 'wc -l';

    return $this;
  }

  public function trim() {
    $this->command[] = "sed -e 's/^ *//;s/ / | /'";

    return $this;
  }

  public function removeNewLines() {
    $this->command[] = "tr -d '\n'";

    return $this;
  }

  public function __toString()
  {
    return 'LC_ALL=C ' . join(' | ', $this->command);
  }
}