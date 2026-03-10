<?php

class Router {
    
    private array $routes = array();

    public function add(string $path, array $params): void {
        
        $this->routes[] = array(
                                "path" => $path,
                                "params" => $params
                                );
    }

}