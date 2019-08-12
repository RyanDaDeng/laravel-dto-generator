<?php

namespace TimeHunter\LaravelDTOGenerator;

use TimeHunter\LaravelDTOGenerator\Services\ArrayToClassGenerator;

use Exception;
use TimeHunter\LaravelDTOGenerator\Services\JsonToClassGenerator;

class DTOGeneratorFactory
{

    /**
     * @param $driver
     * @throws \Exception
     */
    public static function generate($driver)
    {

        switch ($driver) {
            case 'array':
                (new ArrayToClassGenerator())->generate();
                break;
            case 'json':
                (new JsonToClassGenerator())->generate();
                break;
            default:
                throw new Exception('Driver: ' . $driver . ' is not found.');
        }
    }
}
