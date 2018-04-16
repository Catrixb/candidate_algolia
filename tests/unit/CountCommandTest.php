<?php

namespace tests\e2e;

use App\Commands\CountCommand;
use App\Commands\ShellCommand;
use TestCase;

class CountCommandTest extends TestCase
{
  private function getShellCommand($date = 2015, $path = 'tests/fixtures/query_chunk_100.tsv.gz')
  {
    return new ShellCommand($date, base_path($path));
  }

  /**
   * @test
   *
   * @return void
   */
  public function it_counts_the_number_of_distinct_queries_for_the_year_2015()
  {
    $command = new CountCommand(
      $this->getShellCommand('2015')
    );

    $this->assertEquals(
      100, $command->execute()
    );
  }

  /**
   * @test
   *
   * @return void
   */
  public function it_counts_the_number_of_distinct_queries_for_2015_between_04_and_04_59_minute()
  {
    $command = new CountCommand(
      $this->getShellCommand('2015-08-01 00:04')
    );

    $this->assertEquals(
      84, $command->execute()
    );
  }

  /**
   * @test
   *
   * @return void
   */
  public function it_finds_no_queries_for_year_2016()
  {
    $command = new CountCommand(
      $this->getShellCommand('2016')
    );

    $this->assertEquals(
      0, $command->execute()
    );
  }
}
