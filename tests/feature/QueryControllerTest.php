<?php

namespace tests\feature;

use App\Query;
use App\QueryCollection;
use TestCase;

class QueryControllerTest extends TestCase
{
  public function tearDown() {
    parent::tearDown();

    $fileToClean = base_path('tests/fixtures/hn_logs-2015-08-02.tsv.gz');

    if (file_exists($fileToClean)) {
      unlink($fileToClean);
    }

    exec('rm -r ' . base_path('tests/fixtures/cache'));
  }

  private function queryCount($date) {
    return $this->get('1/queries/count/' . $date);
  }

  private function queryPopular($date, $size = '') {
    $parameter = empty($size) ? '' : '?size=' . $size;

    return $this->get('1/queries/popular/' . $date . $parameter);
  }

  /**
   * @test
   */
  public function it_gets_a_count_entry_from_a_valid_date_format() {
    $this->queryCount('2015');

    $this->assertEquals(
      '{"count":573697}', $this->response->getContent()
    );
  }

  /**
   * @test
   */
  public function it_gets_the_top_3_popular_queries_in_2015() {
    $this->queryPopular('2015', 3);

    $expected = new QueryCollection(
      [
        new Query(6675, 'http%3A%2F%2Fwww.getsidekick.com%2Fblog%2Fbody-language-advice'),
        new Query(4652, 'http%3A%2F%2Fwebboard.yenta4.com%2Ftopic%2F568045'),
        new Query(3100, 'http%3A%2F%2Fwebboard.yenta4.com%2Ftopic%2F379035%3Fsort%3D1')
      ]
    );

    $this->assertEquals(
      json_encode($expected->toArray()), $this->response->getContent()
    );
  }

  /**
   * @test
   */
  public function it_gets_the_top_5_popular_queries_for_the_date_2015_08_02() {
    $this->queryPopular('2015-08-02', 5);

    $expected = new QueryCollection(
      [
        new Query(2283, 'http%3A%2F%2Fwww.getsidekick.com%2Fblog%2Fbody-language-advice'),
        new Query(1943, 'http%3A%2F%2Fwebboard.yenta4.com%2Ftopic%2F568045'),
        new Query(1358, 'http%3A%2F%2Fwebboard.yenta4.com%2Ftopic%2F379035%3Fsort%3D1'),
        new Query(890, 'http%3A%2F%2Fjamonkey.com%2F50-organizing-ideas-for-every-room-in-your-house%2F'),
        new Query(701, 'http%3A%2F%2Fsharingis.cool%2F1000-musicians-played-foo-fighters-learn-to-fly-and-it-was-epic')
      ]
    );

    $this->assertEquals(
      json_encode($expected->toArray()), $this->response->getContent()
    );
  }

  /**
   * @test
   * @TODO Check for the missing translation
   */
  public function it_fails_on_popular_request_with_wrong_size_parameter() {
    $this->queryPopular('2015-08-02', "undefined");
    $this->assertEquals(
      '{"size":["validation.integer"]}', $this->response->getContent()
    );

    $this->queryPopular('2015-08-02');
    $this->assertEquals(
      '{"size":["validation.required"]}', $this->response->getContent()
    );
  }
}
