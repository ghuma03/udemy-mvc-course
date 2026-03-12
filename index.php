<?php

spl_autoload_register(function($class_name) {
    require "src/".str_replace("\\", "/", $class_name).".php";
});

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$router = new Framework\Router;
    $router->add("/admin/{controller}/{action}", array("namespace" => "Admin"));
    $router->add("/{title}/{id:\d+}/{page:\d+}", array("controller" => "products", "action" => "showPage"));
    $router->add("/product/{slug:[\w-]+}", array("controller" => "products", "action" => "show"));
    $router->add("/{controller}/{id:\d+}/{action}");
    $router->add("/home/index", array("controller" => "home"      , "action" => "index"));
    $router->add("/products", array("controller" => "products"  , "action" => "index"));
    $router->add("/", array("controller" => "home"      , "action" => "index"));
    $router->add("/{controller}/{action}");

$database = new App\Database("localhost", "product_db", "product_db_user", "secret");

$container = new Framework\Container;
    $container->set(App\Database::class, $database);

$dispatcher = new Framework\Dispatcher($router, $container);
    $dispatcher->handle($path);