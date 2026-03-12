<?php

declare(strict_types = 1);

$show_errors = false;

if ($show_errors === true) {
    ini_set("display_errors", "1");
}
else {

    ini_set("display_errors", "0");
    ini_set("log_errors"    , "1");

    require "views/500.php";
}



spl_autoload_register(function($class_name) {
    require "src/".str_replace("\\", "/", $class_name).".php";
});

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

if ($path === false) {
    throw new UnexpectedValueException("Malformed URL: '{$_SERVER["REQUEST_URI"]}'");
}

$router = new Framework\Router;
    $router->add("/admin/{controller}/{action}", array("namespace" => "Admin"));
    $router->add("/{title}/{id:\d+}/{page:\d+}", array("controller" => "products", "action" => "showPage"));
    $router->add("/product/{slug:[\w-]+}", array("controller" => "products", "action" => "show"));
    $router->add("/{controller}/{id:\d+}/{action}");
    $router->add("/home/index", array("controller" => "home"      , "action" => "index"));
    $router->add("/products", array("controller" => "products"  , "action" => "index"));
    $router->add("/", array("controller" => "home"      , "action" => "index"));
    $router->add("/{controller}/{action}");

$container = new Framework\Container;
    $container->set(App\Database::class, function() {
        return new App\Database("localhost", "product_db", "product_db_user", "secret");
    });

$dispatcher = new Framework\Dispatcher($router, $container);
    $dispatcher->handle($path);