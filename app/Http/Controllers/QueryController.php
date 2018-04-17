<?php

namespace App\Http\Controllers;

use App\ApcCacheFactory;
use App\Cache\CacheFactory;
use App\Cache\QueryFactoryCache;
use App\Config;
use App\QueryFileReducer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller;

class QueryController extends Controller
{
  /**
   *  Returns a JSON object specifying the number of distinct queries that
   *  have been done during a specific time range
   *
   * @param DateRangeHelper $date
   *
   * @return Response
   */
  public function count($date) {
    $cache = new QueryFactoryCache(
      CacheFactory::getCache(),
      Config::self(),
      new QueryFileReducer(Config::self())
    );

    return response()->json(
      $cache->count($date)
    );
  }

  /**
   *  Returns a JSON object listing the top <SIZE> popular
   *  queries that have been done during a specific time range
   *
   * @param Request $request
   * @param DateRangeHelper  $date
   *
   * @return Response
   */
  public function popular(Request $request, $date) {
    $this->validate($request, [
      'size' => 'required|integer'
    ]);

    $size = $request->get('size');

    $cache = new QueryFactoryCache(
      CacheFactory::getCache(),
      Config::self(),
      new QueryFileReducer(Config::self())
    );

    return response()->json(
      $cache->popular($date, $size)
    );
  }
}