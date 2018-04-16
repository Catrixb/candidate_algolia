<?php

namespace App;

use App\Commands\CountCommand;
use App\Commands\PopularCommand;
use App\Commands\ShellCommand;

class QueryFactory
{
  static public function count(\SplFileInfo $file, string $dateRange): Query {
    $command = (new CountCommand(
      new ShellCommand($dateRange, $file)
    ));

    return new Query($command->execute());
  }

  static public function popular(\SplFileInfo $file, string $dateRange, int $size): QueryCollection {
    $command = (new PopularCommand(
      new ShellCommand($dateRange, $file),
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
}