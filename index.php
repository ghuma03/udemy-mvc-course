<?php

spl_autoload_register(function($class_name) {
    require "src/".str_replace("\\", "/", $class_name).".php";
});

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// require "src/router.php";

$router = new Framework\Router;
    $router->add("/{controller}/{action}");
    $router->add("/home/index"          , array("controller" => "home"      , "action" => "index"));
    $router->add("/products"            , array("controller" => "products"  , "action" => "index"));
    $router->add("/"                    , array("controller" => "home"      , "action" => "index"));

$params = $router->match($path);

if ($params === false) {
    exit("No route matched!");
}

$controller = "App\Controllers\\" . ucwords($params["controller"]);
$action = $params["action"];

$controller_object = new $controller;
    $controller_object->$action();