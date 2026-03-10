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

        $pattern = "#^/(?<controller>[a-z]+)/(?<action>[a-z]+)$#";
        
        if (preg_match($pattern, $path, $matches)) {

            $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);

            return $matches;

            print_r($matches);

            exit("Match");
        }

        /*
        foreach ($this->routes as $route) {

            if ($route["path"] == $path) {
                return $route["params"];
            }
        }
        */
        
        return false;
    }

}