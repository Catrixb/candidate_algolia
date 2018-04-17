<?php

namespace App;

use App\Commands\CountCommand;
use App\Commands\PopularCommand;
use App\Commands\ShellCommand;
use App\Commands\ShellCommandToFile;

class QueryFactory
{
  static public function count(\SplFileInfo $file, string $date): Query {
    $command = (new CountCommand(
      new ShellCommand($date, $file)
    ));

    return new Query($command->execute());
  }

  static public function popular(\SplFileInfo $file, string $date, int $size): QueryCollection {
    $command = (new PopularCommand(
      new ShellCommand($date, $file),
      $size
    ));

    $queries = explode("\n", $command->execute(), $size);
    
    $queries = collect($queries)->filter()->map(function($q) {
      list($count, $query) = explode(" ", $q);

      return new Query($count, $query);
    });

    $collection = new QueryCollection($queries->toArray());

    return $collection;
  }

  static public function reduce(\SplFileInfo $from, string $to, string $date) {
    $command = new ShellCommandToFile(
      new ShellCommand($date, $from),
      $to
    );

    return $command->execute();
  }
}