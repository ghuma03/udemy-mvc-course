<?php

class Router {
    
    private array $routes = array();

    public function add(string $path, array $params): void {

        $this->routes[] = array(
                                "path" => $path,
                                "params" => $params
                                );
    }

    public function match(string $path): array|bool {

        foreach ($this->routes as $route) {

            if ($route["path"] == $path) {
                return $route["params"];
            }
        }
        
        return false;
    }

}