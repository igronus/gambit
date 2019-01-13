<?php

namespace App;

use Illuminate\Support\Facades\Cache;

/**
 * The implementation is responsible for putting/getting cached data.
 *
 * @author igronus
 */
class Cacher implements CacherInterface
{
    private $seconds;

    public function __construct($seconds)
    {
        $this->seconds = $seconds;
    }

    function put($key, $value)
    {
        Cache::put($key, $value, $this->seconds / 60);
    }

    function get($key)
    {
        return Cache::get($key);
    }
}
