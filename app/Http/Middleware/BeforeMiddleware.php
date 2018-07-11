<?php

namespace App\Http\Middleware;

use App\Config;
use Closure;

class BeforeMiddleware
{
  /**
   * @warning only used for a demo purpose
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure                 $next
   *
   * @return mixed
   */
  public function handle($request, Closure $next) {
    $toStorage = Config::self()->getFullPath('2015');

    if (!is_dir(storage_path('app/queries'))) {
      mkdir(storage_path('app/queries'));
    }

    if (!file_exists($toStorage)) {
      $fromFixture = base_path('tests/fixtures/hn_logs-2015.tsv.gz');

      copy($fromFixture, $toStorage);
    }

    return $next($request);
  }
}
