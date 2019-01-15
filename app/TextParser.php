<?php

namespace App;

/**
 * Text parser
 *
 * @author igronus
 */
class TextParser implements ParserInterface
{
    public function parse($data)
    {
        $datetime = null; $registers = [];
        $lines = explode("\n", $data);

        foreach ($lines as $key => $line) {
            if ( ! $line) {
                break;
            }

            if ($key === 0) {
                // TODO check datetime with regexp here
                $datetime = $line;
                continue;
            }

            $registerData = explode(':', $line);
            if (count($registerData) !== 2) {
                throw new \Exception('TextParser: Wrong feed');
            }

            $registers[$key] = (int) $registerData[1];
        }

        return [
            'datetime' => $datetime,
            'registers' => $registers,
        ];
    }
}
