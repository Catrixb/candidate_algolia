<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => '1/queries/'], function() use ($router) {
  $dateRangeValidation = '[0-9]{4}(?:-\d{2})?(?:-\d{2})?(?:%20\d{2}:\d{2})?';

  $router
    ->get('count/{dateRange:'. $dateRangeValidation .'}', [
      'uses' => 'QueryController@count',
      'middleware' => ['queries']
    ]);

  $router
    ->get('popular/{dateRange:'. $dateRangeValidation .'}', [
      'uses' => 'QueryController@popular',
      'middleware' => ['queries']
    ]);
});