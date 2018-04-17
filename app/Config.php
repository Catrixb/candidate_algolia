<?php

namespace App;

class Config
{
  static public function get($key, $default = null) {
    if (app()->environment() === 'testing') {
      return config('test.' . $key, $default);
    }

    return config('app.' . $key, $default);
  }
}