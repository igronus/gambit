<?php

namespace App;

/**
 * TUF-2000M
 *
 * @author igronus
 */
class TUF2000M implements \JsonSerializable
{
    use JsonTrait;

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

        'data'
    ];

    private $jsonMethods = [
        'rand',
    ];

    public function rand()
    {
        $this->data = rand(0, 100);
    }
}
