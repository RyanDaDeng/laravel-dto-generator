<?php

namespace TimeHunter\LaravelJsonToClassGenerator\Services;


use Illuminate\Support\Facades\File;
use Nette\PhpGenerator\PhpFile;

/**
 * Class JsonToClassGenerator
 * @package TimeHunter\LaravelJsonToClassGenerator\Services
 */
abstract class AbstractClassGenerator
{
    /**
     * @return array
     */
    abstract protected function getData(): array;

    /**
     * Generate classes
     */
    public function generate()
    {
        $this->recursiveCreateFile($this->getData(), config('jsontoclassgenerator.namespace'));
    }

    /**
     * @param $sample
     * @param $namespaceString
     */
    private function recursiveCreateFile($sample, $namespaceString)
    {
        foreach ($sample as $key => $data) {
            $className = $this->convertClassName($key);
            $phpFile   = new PhpFile();
            $namespace = $phpFile->addNamespace($namespaceString);
            $class     = $namespace->addClass($className);

            $class->addMethod('create')->setStatic(true)->setBody('return new self;')->addComment('@return ' . $className);
            $toArray = "return [\n";
            foreach ($data as $itemKey => $item) {
                $camelCase = $this->convert($itemKey);

                if (is_object($item)) {
                    $subClassName = $this->convertClassName($itemKey);

                    $class->addProperty($camelCase)->addComment('@var ' . ucfirst($camelCase) . ' $' . $camelCase);
                    $class->addMethod('add' . ucfirst($camelCase))->addComment('@param ' . ucfirst($camelCase) . ' $' . $camelCase . "\n" . '@return $this')->setBody('$this->' . $camelCase . ' = ' . '$' . $camelCase . ';' . "\n" . 'return $this;')->addParameter($camelCase);

                    $toArray .= "   '$itemKey' => " . '$this->' . $camelCase . '->toArray()' . ',' . "\n";
                    $this->recursiveCreateFile([$itemKey => $item], $namespaceString);
                } else {
                    if (is_array($item)) {
                        $subClassName = $this->convertClassName($itemKey);

                        $class->addProperty($camelCase)->addComment('@var ' . ucfirst($camelCase) . ' $' . $camelCase);
                        $class->addMethod('add' . ucfirst($camelCase))->addComment('@param ' . ucfirst($camelCase) . ' $' . $camelCase . "\n" . '@return $this')->setBody('$this->' . $camelCase . '[] = ' . '$' . $camelCase . ';' . "\n" . 'return $this;')->addParameter($camelCase);

                        $toArray .= "   '$itemKey' => " . 'collect($this->' . $camelCase . ')->map(function (' . "$subClassName" . ' $data){
        return $data->toArray();
    })->toArray()' . ',' . "\n";
                        $this->recursiveCreateFile([$itemKey => $item], $namespaceString);
                    } else {
                        $class->addProperty($camelCase)->addComment('@var $' . $camelCase);
                        $toArray .= "   '$itemKey' => " . '$this->' . $camelCase . ',' . "\n";
                    }
                }
            }
            $toArray .= "];";
            $class->addMethod('toArray')->addComment('@return array')->setReturnType('array')->setBody($toArray); // method return type;

            $file = $className . '.php';

            $location = config('jsontoclassgenerator.file_location') . '/' . $file;
            File::put($location, $phpFile);
        }
    }

    /**
     * @param $string
     * @return string
     */
    private function convert($string)
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        return lcfirst($str);
    }

    /**
     * @param $string
     * @return mixed
     */
    private function convertClassName($string)
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        return $str;
    }
}
