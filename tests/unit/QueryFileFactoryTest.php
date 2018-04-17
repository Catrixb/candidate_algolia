<?php

namespace tests\e2e;

use App\QueryFileFactory;
use TestCase;

class QueryFileFactoryTest extends TestCase
{
  public function tearDown() {
    parent::tearDown();

    $fileToClean = base_path('tests/fixtures/hn_logs-2015-08.tsv.gz');

    if (file_exists($fileToClean)) {
      unlink($fileToClean);
    }
  }

  /**
   * @test
   */
  public function it_gets_the_path_of_the_year_file() {
    $path = base_path('tests/fixtures/');

    $this->assertEquals(
      $path . 'hn_logs-2015.tsv.gz',
      QueryFileFactory::getFileInfo('2015', $path)->getRealPath()
    );
  }

  /**
   * @test
   */
  public function it_gets_the_path_of_the_month_file() {
    $path = base_path('tests/fixtures/');

    $this->assertEquals(
      $path . 'hn_logs-2015-08.tsv.gz',
      QueryFileFactory::getFileInfo('2015-08', $path)->getRealPath()
    );
  }
}
