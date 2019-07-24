<?php

namespace TimeHunter\LaravelJsonToClassGenerator\Services;


use Illuminate\Support\Facades\File;
use Nette\PhpGenerator\PhpFile;

/**
 * Class JsonToClassGenerator
 * @package TimeHunter\LaravelJsonToClassGenerator\Services
 */
class JsonToClassGenerator extends AbstractClassGenerator
{

    /**
     * @return array
     */
    public function getData(): array
    {
        return json_decode(config('jsontoclassgenerator.json'),1);
    }

}