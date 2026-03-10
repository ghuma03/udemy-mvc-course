<?php

namespace Framework;

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
            $controller_object->$action();
    }

}