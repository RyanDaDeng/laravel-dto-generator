<?php

namespace TimeHunter\LaravelJsonToClassGenerator\Services;


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
        return config('jsontoclassgenerator.array');
    }
}