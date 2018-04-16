<?php

namespace App\Http\Controllers;

use App\QueryFactory;
use App\QueryFileFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    return response()->json(
      QueryFactory::count(
        QueryFileFactory::getFileInfo($dateRange),
        $dateRange
      )
    );
  }

  /**
   *  Returns a JSON object listing the top <SIZE> popular
   *  queries that have been done during a specific time range
   *
   * @param Request $request
   * @param string  $dateRange
   *
   * @return Response
   */
  public function popular(Request $request, $dateRange) {
    $this->validate($request, [
      'size' => 'required|integer'
    ]);

    $size = $request->get('size');

    return response()->json(
      QueryFactory::popular(
        QueryFileFactory::getFileInfo($dateRange),
        $dateRange,
        $size
      )
    );
  }
}