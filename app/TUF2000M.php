<?php

namespace App;

/**
 * TUF-2000M
 *
 * @author igronus
 */
class TUF2000M extends ModbusDevice implements \JsonSerializable
{
    private $name = 'unknown';
    private $model = 'TUF-2000M';

    public function __construct($name)
    {
        $this->name = $name;
    }


    use JsonTrait;

    private $jsonAttributes = [
        'name',
        'model',

        'rawData',

        'datetime',
        'registers',

        'data'
    ];

    private $jsonMethods = [
        'parseData',
    ];


    protected $dataSources = [
        'energy' => [
            'name' => 'Negative energy accumulator',
            'registers' => [
                '21:1',
                '21:0',
                '22:1',
                '22:0',
            ],
            'type' => Converter::UINT32,
        ],
        'temperature' => [
            'name' => 'Temperature #1/inlet',
            'registers' => [
                '34:0',
                '34:1',
                '33:0',
                '33:1',
            ],
            'type' => Converter::FLOAT32,
        ],
        'signal' => [
            'name' => 'Signal Quality',
            'registers' => [
                '92:1',
            ],
            'type' => Converter::INT8,
        ],
    ];
}
