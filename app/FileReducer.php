<?php

namespace App;

interface FileReducer
{
  public function reduce(string $value);
  public function clean(string $value);
}