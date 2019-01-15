<?php

namespace App;

/**
 * TUF-2000M
 *
 * @author igronus
 */
class TUF2000M implements \JsonSerializable
{
    private $name = 'unknown';
    private $model = 'TUF-2000M';

    public function __construct($name)
    {
        $this->name = $name;
    }


    private $jsonAttributes = [
        'name',
        'model',

        'rawData',

        'datetime',
        'registers',
    ];

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        foreach ($vars as $key => $var) {
            if ( ! in_array($key, $this->jsonAttributes)) {
                unset($vars[$key]);
            }
        }

        return $vars;
    }
}
