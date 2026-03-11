<?php

namespace Framework;

use ReflectionMethod;
use ReflectionClass;

class Dispatcher {

    private Router $router;

    public function __construct(Router $router) {
        $this->router = $router;
    }

    public function handle(string $path) {

        $params = $this->router->match($path);

        if ($params === false) {
            exit("No route matched!");
        }

        $controller = $this->getControllerName($params);
        $controller_object = $this->getObject($controller);

        $action = $this->getActionName($params);
        $args = $this->getActionArguments($controller, $action, $params);

        $controller_object->$action(...$args);
    }

    private function getActionArguments(string $controller, string $action, array $params): array {

        $method = new ReflectionMethod($controller, $action);

        $args = array();
        foreach ($method->getParameters() as $parameter) {

            $name = $parameter->getName();

            $args[$name] = $params[$name];
        }

        return $args;
    }

    private function getControllerName(array $params): string {

        $controller = $params["controller"];
            $controller = strtolower($controller);
            $controller = ucwords($controller, "-");
            $controller = str_replace("-", "", $controller);

        $namespace = "App\Controllers";
        if (array_key_exists("namespace", $params)) {
            $namespace .= "\\" . $params["namespace"];
        }

        return $namespace . "\\" . $controller;
    }

    private function getActionName(array $params): string {

        $action = $params["action"];
            $action = strtolower($action);
            $action = ucwords($action, "-");
            $action = str_replace("-", "", $action);
            $action = lcfirst($action);

        return $action;
    }

    private function getObject(string $class_name): object {

        $reflector = new ReflectionClass($class_name);
        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return new $class_name;
        }

        $dependencies = array();
        foreach ($constructor->getParameters() as $parameter) {
            $type = (string) $parameter->getType();
            $dependencies[] = $this->getObject($type);
        }
        
        return new $class_name(...$dependencies);
    }

}