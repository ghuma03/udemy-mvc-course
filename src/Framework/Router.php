<?php

namespace Framework;

class Router {
    
    private array $routes = array();

    public function add(string $path, array $params): void {

        $this->routes[] = array(
                                "path" => $path,
                                "params" => $params
                                );
    }

    public function match(string $path): array|bool {

        $pattern = "#^/[a-z]+/[a-z]+$#";
        
        if (preg_match($pattern, $path)) {
            exit("Match");
        }

        foreach ($this->routes as $route) {

            if ($route["path"] == $path) {
                return $route["params"];
            }
        }
        
        return false;
    }

}