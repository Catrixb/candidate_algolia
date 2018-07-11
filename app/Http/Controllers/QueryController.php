<?php

namespace App\Http\Controllers;

use App\ApcCacheFactory;
use App\Cache\QueryFactoryCache;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller;

class QueryController extends Controller
{
  private $query;

  public function __construct(QueryFactoryCache $query) {
    $this->query = $query;
  }
  /**
   *  Returns a JSON object specifying the number of distinct queries that
   *  have been done during a specific time range
   *
   * @param DateRangeHelper $date
   *
   * @return Response
   */
  public function count($date) {
    return response()->json(
      $this->query->count(urldecode($date))
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

    return response()->json(
      $this->query->popular(
        urldecode($date), 
        $request->get('size')
      )
    );
  }
}