<?php


class QueryControllerTest extends TestCase
{
  private function queryCount($dateRange) {
    return $this->get('1/queries/count/' . $dateRange);
  }

  /**
   * @test
   *
   * @return void
   */
  public function it_gets_a_count_entry_from_a_valid_date_format()
  {
    $this->queryCount('2015');

    $this->assertEquals(
      '{"count":573697}', $this->response->getContent()
    );
  }

  /**
   * @test
   */
  public function it_gets_a_404_from_invalid_format_date()
  {
    $this->queryCount('201');
    $this->assertEquals(404, $this->response->getStatusCode());
    $this->queryCount('2015-2');
    $this->assertEquals(404, $this->response->getStatusCode());
    $this->queryCount('2015-12-1');
    $this->assertEquals(404, $this->response->getStatusCode());
    $this->queryCount('2015-12-10 1');
    $this->assertEquals(404, $this->response->getStatusCode());
    $this->queryCount('2015-12-10 00:1');
    $this->assertEquals(404, $this->response->getStatusCode());
  }
}
