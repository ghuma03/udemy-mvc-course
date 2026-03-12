<?php

declare(strict_types = 1);

namespace Framework;

use ReflectionClass;
use Closure;
use ReflectionNamedType;
use Exception;

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
                throw new Exception("Constructor parameter '{$parameter->getName()}' in the $class_name class has no type declaration");
            }

            if ( ! ($type instanceof ReflectionNamedType) ) {
                throw new Exception("Constructor parameter '{$parameter->getName()}' in the $class_name class is an invalid type: '$type'. Only single named types supported");
            }

            if ($type->isBuiltIn() === true) {
                throw new Exception("Unable to resolve constructor parameter '{$parameter->getName()}' of type '$type' of the $class_name class");
            }

            $dependencies[] = $this->get((string) $type);
        }
        
        return new $class_name(...$dependencies);
    }
}