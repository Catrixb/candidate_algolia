<?php

namespace tests\e2e;

use App\QueryFactory;
use TestCase;

class CountCommandTest extends TestCase
{
  private function getQuery($dateRange) {
    return QueryFactory::count(
      new \SplFileInfo(base_path('tests/fixtures/query_chunk_100.tsv.gz')),
      $dateRange
    );
  }

  /**
   * @test
   *
   * @return void
   */
  public function it_counts_the_number_of_distinct_queries_for_the_year_2015() {
    $this->assertEquals(100, $this->getQuery(2015)->getCount());
  }

  /**
   * @test
   *
   * @return void
   */
  public function it_counts_the_number_of_distinct_queries_for_2015_between_04_and_04_59_minute() {
    $this->assertEquals(84, $this->getQuery('2015-08-01 00:04')->getCount());
  }

  /**
   * @test
   *
   * @return void
   */
  public function it_finds_no_queries_for_year_2016() {
    $this->assertEquals(0, $this->getQuery('2016')->getCount());
  }
}
