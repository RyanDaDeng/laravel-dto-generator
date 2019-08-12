<?php

namespace TimeHunter\LaravelDTOGenerator\Services;


/**
 * Class JsonToClassGenerator
 * @package TimeHunter\LaravelJsonToClassGenerator\Services
 */
class ArrayToClassGenerator extends AbstractClassGenerator
{

    /**
     * @return array
     */
    public function getData(): array
    {
        return config('dto-generator.array');
    }
}