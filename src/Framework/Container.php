<?php

declare(strict_types = 1);

namespace Framework;

use ReflectionClass;
use Closure;
use ReflectionNamedType;

class Container {

    private array $registry = array();

    public function set(string $name, Closure $value): void {
        $this->registry[$name] = $value;
    }

    public function get(string $class_name): object {

        if (array_key_exists($class_name, $this->registry)) {
            return $this->registry[$class_name]();
        }

        $reflector = new ReflectionClass($class_name);
        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return new $class_name;
        }

        $dependencies = array();
        foreach ($constructor->getParameters() as $parameter) {

            $type = $parameter->getType();

            if ($type === null) {
                echo "Constructor parameter '{$parameter->getName()}' in the $class_name class has no type declaration";
                die();
            }

            if ( ! ($type instanceof ReflectionNamedType) ) {
                echo "Constructor parameter '{$parameter->getName()}' in the $class_name class is an invalid type: '$type'. Only single named types supported";
                die();
            }

            if ($type->isBuiltIn() === true) {
                echo "Unable to resolve constructor parameter '{$parameter->getName()}' of type '$type' of the $class_name class";
                die();
            }

            $dependencies[] = $this->get((string) $type);
        }
        
        return new $class_name(...$dependencies);
    }
}