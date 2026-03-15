<?php

$router = new Framework\Router;
    $router->add("/admin/{controller}/{action}", array("namespace" => "Admin"));
    $router->add("/{title}/{id:\d+}/{page:\d+}", array("controller" => "products", "action" => "showPage"));
    $router->add("/product/{slug:[\w-]+}", array("controller" => "products", "action" => "show"));

    // $router->add("/{controller}/{id:\d+}/{action}");
    $router->add("/{controller}/{id:\d+}/show", array("action" => "show"));
    $router->add("/{controller}/{id:\d+}/edit", array("action" => "edit"));
    $router->add("/{controller}/{id:\d+}/update", array("action" => "update"));
    $router->add("/{controller}/{id:\d+}/delete", array("action" => "delete"));
    $router->add("/{controller}/{id:\d+}/destroy", array("action" => "destroy", "method" => "post"));

    $router->add("/home/index", array("controller" => "home"      , "action" => "index"));
    $router->add("/products", array("controller" => "products"  , "action" => "index"));
    $router->add("/", array("controller" => "home"      , "action" => "index"));
    $router->add("/{controller}/{action}");

return $router;