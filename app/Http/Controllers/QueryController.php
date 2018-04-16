<?php

namespace App\Http\Controllers;

use App\CountCommand;
use App\PopularCommand;
use App\QueryCollection;
use App\ShellCommand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller;

class QueryController extends Controller
{
  private $localQueryPath = 'app/queries/2015/hn_logs.tsv.gz';
  private $filePath;

  public function __construct() {
    $filePath = storage_path($this->localQueryPath);

    if (!file_exists($filePath)) {
      abort(Response::HTTP_NOT_FOUND);
    }

    $this->filePath = $filePath;
  }

  /**
   *  Returns a JSON object specifying the number of distinct queries that
   *  have been done during a specific time range
   *
   * @param string $dateRange
   *
   * @return Response
   */
  public function count($dateRange) {
    $command = (new CountCommand(
      new ShellCommand($dateRange, $this->filePath)
    ));

    return response()->json(['count' => $command->execute()]);
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

    $command = (new PopularCommand(
      new ShellCommand($dateRange, $this->filePath),
      $size
    ));

    $collection = new QueryCollection($command->execute());

    return response()->json($collection->toArray());
  }
}