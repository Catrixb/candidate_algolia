<?php

namespace tests\unit;

use App\Query;
use App\QueryCollection;
use App\QueryFactory;
use TestCase;

class PopularCommandTest extends TestCase
{
  private function getQueries($date, $size) {
    return QueryFactory::popular(
      new \SplFileInfo(base_path('tests/fixtures/query_chunk_500.tsv.gz')),
      $date,
      $size
    );
  }

  /**
   * @test
   *
   * @return void
   */
  public function it_lists_the_number_of_popular_queries_for_year_2015() {
    $expected = new QueryCollection(
      [
        new Query(3, 'https%3A%2F%2Fwww.comparis.ch%2Fsparzinsen%2Fdefault.aspx'),
        new Query(3, 'etherium'),
        new Query(2, 'linux'),
        new Query(2, 'http%3A%2F%2Fwww.darkreading.com%2Fdrdigital%2F20150601td%3Fcid%3Dsmartbox_techweb_drdigital_20150601td')
      ]
    );

    $queries = $this->getQueries('2015', 4);

    $this->assertEquals(
      $expected->toArray(), $queries->toArray()
    );
  }

  /**
   * @test
   *
   * @return void
   */
  public function it_finds_no_queries_for_year_2016() {
    $queries = $this->getQueries('2016', 4);

    $this->assertEquals(
      ['queries' => []], $queries->toArray()
    );
  }
}
