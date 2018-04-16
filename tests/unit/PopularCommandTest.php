<?php

namespace tests\e2e;

use App\CountCommand;
use App\PopularCommand;
use App\Query;
use App\QueryCollection;
use App\ShellCommand;
use TestCase;

class PopularCommandTest extends TestCase
{
  private function getShellCommand($date = 2015, $path = 'tests/fixtures/query_chunk_500.tsv.gz') {
    return new ShellCommand($date, base_path($path));
  }

  /**
   * @test
   *
   * @return void
   */
  public function it_lists_the_number_of_popular_queries_for_year_2015() {
    $command = new PopularCommand(
      $this->getShellCommand('2015'),
      4
    );

    $expected = new QueryCollection(
      [
        new Query(3, 'https%3A%2F%2Fwww.comparis.ch%2Fsparzinsen%2Fdefault.aspx'),
        new Query(3, 'etherium'),
        new Query(2, 'linux'),
        new Query(2, 'http%3A%2F%2Fwww.darkreading.com%2Fdrdigital%2F20150601td%3Fcid%3Dsmartbox_techweb_drdigital_20150601td')
      ]
    );

    $result = new QueryCollection($command->execute());

    $this->assertEquals(
      $expected->toArray(), $result->toArray()
    );
  }

  /**
   * @test
   *
   * @return void
   */
  public function it_finds_no_queries_for_year_2016() {
    $command = new PopularCommand(
      $this->getShellCommand('2016'),
      4
    );

    $result = new QueryCollection($command->execute());

    $this->assertEquals(
      ['queries' => []], $result->toArray()
    );
  }
}
