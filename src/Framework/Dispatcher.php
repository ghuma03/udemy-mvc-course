<?php

namespace Framework;

use ReflectionMethod;

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

        $controller = "App\Controllers\\" . ucwords($params["controller"]);
        $action = $params["action"];

        $controller_object = new $controller;

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

}