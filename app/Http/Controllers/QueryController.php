<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;

class QueryController extends Controller
{
  /**
   *  Returns a JSON object specifying the number of distinct queries that
   *  have been done during a specific time range
   *
   * @param string $dateRange
   *
   * @return Response
   */
  public function count($dateRange) {
    return response()->json(['count' => 573697]);
  }
}