<?php

namespace App;

/**
 * This interface can be reused in other models later.
 *
 * @author igronus
 */
trait JsonTrait
{
    public function jsonSerialize()
    {
        if ( ! $this->jsonAttributes) {
            $this->jsonAttributes = [];
        }

        if ( ! $this->jsonMethods) {
            $this->jsonMethods = [];
        }


        foreach ($this->jsonMethods as $method) {
            $this->{$method}();
        }


        $vars = get_object_vars($this);

        foreach ($vars as $key => $var) {
            if ( ! in_array($key, $this->jsonAttributes)) {
                unset($vars[$key]);
            }
        }


        return $vars;
    }
}
