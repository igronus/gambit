<?php

namespace App;

class ModbusDevice
{
    protected $dataSources = [];

    public function getRegisterBytes($i)
    {
        if ( ! isset($this->registers[$i])) {
            throw new \Exception('ModbusDevice: Register is not set');
        }

        $binaryString = sprintf( "%016d", decbin($this->registers[$i]));

        return [
            substr($binaryString, 0, 8),
            substr($binaryString, 8, 8)
        ];
    }

    public function parseData()
    {
        if ( ! isset($this->data)) {
            $this->data = [];
        }

        foreach ($this->dataSources as $tag => $dataAttribute) {
            $dataObject = new \stdClass();
            $dataObject->tag = $tag;
            $dataObject->name = $dataAttribute['name'];

            $binaryString = '';
            foreach ($dataAttribute['registers'] as $register) {
                $registerNumber = explode(':', $register)[0];
                $registerByte = explode(':', $register)[1];
                $binaryString .= $this->getRegisterBytes($registerNumber)[$registerByte];
            }
            $dataObject->binaryString = $binaryString;
            $dataObject->value = Converter::convert($binaryString, $dataAttribute['type']);

            $this->data[] = $dataObject;
        }
    }
}
