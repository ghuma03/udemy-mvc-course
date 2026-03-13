<?php

$router = new Framework\Router;
    $router->add("/admin/{controller}/{action}", array("namespace" => "Admin"));
    $router->add("/{title}/{id:\d+}/{page:\d+}", array("controller" => "products", "action" => "showPage"));
    $router->add("/product/{slug:[\w-]+}", array("controller" => "products", "action" => "show"));
    $router->add("/{controller}/{id:\d+}/{action}");
    $router->add("/home/index", array("controller" => "home"      , "action" => "index"));
    $router->add("/products", array("controller" => "products"  , "action" => "index"));
    $router->add("/", array("controller" => "home"      , "action" => "index"));
    $router->add("/{controller}/{action}");

return $router;