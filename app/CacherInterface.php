<?php

namespace App;

/**
 * This interface is used to guarantee correct methods and arguments existing.
 *
 * @author igronus
 */
interface CacherInterface
{
    public function put($key, $value);

    public function get($key);
}
