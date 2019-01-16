<?php

namespace App;

class Converter
{
    const UINT32 = 0;
    const FLOAT32 = 1;
    const INT8 = 2;

    public static function convert($binary_string, $type)
    {
        if ( ! preg_match('/^((0|1){8})+$/', $binary_string)) {
            throw new \Exception('Converter: Wrong binary string');
        }


        switch ($type) {
            case self::UINT32:
                $bytes = 4;
                $unpackType = 'i';
                break;
            case self::FLOAT32:
                $bytes = 4;
                $unpackType = 'G';
                break;
            case self::INT8:
                $bytes = 1;
                $unpackType = 'c';
                break;
            default:
                throw new \Exception('Converted: Unknown type');
        }


        $hex = base_convert($binary_string, 2, 16);

        if (strlen($hex) < $bytes*2) {
            $hex = str_repeat('0', $bytes*2 - strlen($hex)) . $hex;
        }


        $binary = hex2bin($hex);
        return unpack($unpackType, $binary)[1];
    }
}
