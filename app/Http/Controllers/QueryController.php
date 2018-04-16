<?php

namespace App\Http\Controllers;

use App\CountCommand;
use App\ShellCommand;
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
    $filePath = storage_path('app/hn_logs.tsv.gz');

    if (!file_exists($filePath)) {
      abort(404);
    }

    $command = (new CountCommand(
      new ShellCommand($dateRange, $filePath)
    ));

    return response()->json(['count' => $command->execute()]);
  }
}