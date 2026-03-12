<?php

declare(strict_types = 1);

namespace Framework;

use ReflectionMethod;

class Dispatcher {

    private Router $router;
    private Container $container;

    public function __construct(Router $router, Container $container) {
        $this->router = $router;
        $this->container = $container;
    }

    public function handle(string $path) {

        $params = $this->router->match($path);

        if ($params === false) {
            exit("No route matched!");
        }

        $controller = $this->getControllerName($params);
        $controller_object = $this->container->get($controller);

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
}