<?php

namespace TimeHunter\LaravelDTOGenerator\Services;


use Illuminate\Support\Facades\File;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;

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
        $this->recursiveCreateFile($this->getData(), config('dto-generator.namespace'));
    }

    public function getType($value)
    {

        if ($value === null) {
            return;
        }

        if (is_string($value)) {
            return 'string';
        }

        if (($value === true || $value === false) === true) {
            return 'bool';
        }

        if (is_int($value)) {
            return 'int';
        }

        if (is_float($value)) {
            return 'float';
        }
        return;
    }

    public function addMethod(ClassType $class, $type, $name,$isArray = false)
    {

        $realType = last(explode('\\', $type));

        $getComment = empty($realType) ? 'mixed' : $realType;


        if($isArray === true){
            $class->addMethod('get' . ucfirst($name))
                ->addComment('@return ' . $getComment)
                ->setBody('return $this->' . $name . ';');

            $class->addMethod('set' . ucfirst($name))
                ->setReturnType('self')
                ->addComment('@param ' . $realType . ' $' . $name . "\n" . '@return $this')
                ->setBody('$this->' . $name . ' = ' . '$' . $name . ';' . "\n" . 'return $this;')
                ->addParameter($name);
        }else{
            $class->addMethod('get' . ucfirst($name))
                ->setReturnType($type)
                ->addComment('@return ' . $getComment)
                ->setBody('return $this->' . $name . ';');

            $class->addMethod('set' . ucfirst($name))
                ->setReturnType('self')
                ->addComment('@param ' . $realType . ' $' . $name . "\n" . '@return $this')
                ->setBody('$this->' . $name . ' = ' . '$' . $name . ';' . "\n" . 'return $this;')
                ->addParameter($name)
                ->setTypeHint($type);
        }


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
                    $namespace->addUse($namespaceString . '\\' . ucfirst($camelCase), ucfirst($camelCase));
                    $class->addProperty($camelCase)->setVisibility('private')->addComment('@var ' . ucfirst($camelCase) . ' $' . $camelCase);
                    $class->addMethod('add' . ucfirst($camelCase))
                        ->setReturnType('self')
                        ->addComment('@param ' . $camelCase . ' $' . $camelCase . "\n" . '@return $this')
                        ->setBody('$this->' . $camelCase . ' = ' . '$' . $camelCase . ';' . "\n" . 'return $this;')
                        ->addParameter($camelCase)
                        ->setTypeHint($namespaceString . '\\' . ucfirst($camelCase));

                    $toArray .= "   '$itemKey' => " . '$this->' . $camelCase . '->toArray()' . ',' . "\n";
                    $this->addMethod($class, $namespaceString . '\\' . ucfirst($camelCase), $camelCase);
                    $this->recursiveCreateFile([$itemKey => $item], $namespaceString);
                } else {

                    if (is_array($item)) {
                        $subClassName = $this->convertClassName($itemKey);
                        $namespace->addUse($namespaceString . '\\' . ucfirst($camelCase), ucfirst($camelCase));
                        $class->addProperty($camelCase,
                            [])->addComment('@var ' . ucfirst($camelCase) . '[] $' . $camelCase)->setVisibility('private');
                        $class->addMethod('add' . ucfirst($camelCase))
                            ->setReturnType('self')
                            ->addComment('@param ' . $camelCase . ' $' . $camelCase . "\n" . '@return $this')
                            ->setBody('$this->' . $camelCase . '[] = ' . '$' . $camelCase . ';' . "\n" . 'return $this;')
                            ->addParameter($camelCase)
                            ->setTypeHint($namespaceString . '\\' . ucfirst($camelCase));
//
//                        $toArray .= "   '$itemKey' => " . 'collect($this->' . $camelCase . ')->map(function (' . ucfirst($camelCase) . ' $data){
//        return $data->toArray();
//    })->toArray()' . ',' . "\n";

                        $toArray .="   '$itemKey' => " ."array_map(function (".ucfirst($camelCase). ' $data){
          return $data->toArray();
      }, $this->'.$camelCase.")" .',' . "\n";


                        $this->addMethod($class, $namespaceString . '\\' . ucfirst($camelCase).'[]', $camelCase,true);
                        $this->recursiveCreateFile([$itemKey => $item], $namespaceString);
                    } else {
                        $propertyType = $this->getType($item);
                        $class->addProperty($camelCase)->setVisibility('private')->addComment('@var ' . $propertyType . ' $' . $camelCase);
                        $this->addMethod($class, $propertyType, $camelCase, $namespaceString);
                        $toArray .= "   '$itemKey' => " . '$this->' . $camelCase . ',' . "\n";
                    }
                }
            }
            $toArray .= "];";
            $class->addMethod('toArray')->addComment('@return array')->setReturnType('array')->setBody($toArray); // method return type;

            $file = $className . '.php';

            $location = config('dto-generator.file_location') . '/' . $file;
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
