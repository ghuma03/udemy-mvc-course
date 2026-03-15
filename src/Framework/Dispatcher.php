<?php

declare(strict_types = 1);

namespace Framework;

use ReflectionMethod;
use Framework\Exceptions\PageNotFoundException;
use UnexpectedValueException;

class Dispatcher {

    private Router $router;
    private Container $container;

    public function __construct(Router $router, Container $container) {
        $this->router = $router;
        $this->container = $container;
    }

    public function handle(Request $request) {

        $path = $this->getPath($request->uri);
        $params = $this->router->match($path, $request->method);

        if ($params === false) {
            throw new PageNotFoundException("No route matched for '$path' with method {$request->method}!");
        }

        $controller = $this->getControllerName($params);

        $controller_object = $this->container->get($controller);
            $controller_object->setRequest($request);
            $controller_object->setViewer($this->container->get(Viewer::class));

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

    private function getPath(string $uri): string {

        $path = parse_url($uri, PHP_URL_PATH);

        if ($path === false) {
            throw new UnexpectedValueException("Malformed URL: '{$uri}'");
        }

        return $path;
    }
}