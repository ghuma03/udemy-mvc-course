<?php

spl_autoload_register(function($class_name) {
    require "src/$class_name.php";
});

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// require "src/router.php";

$router = new Router();
    $router->add("/home/index"  , array("controller" => "home"      , "action" => "index"));
    $router->add("/products"    , array("controller" => "products"  , "action" => "index"));
    $router->add("/"            , array("controller" => "home"      , "action" => "index"));

$params = $router->match($path);

if ($params === false) {
    exit("No route matched!");
}

$controller = $params["controller"];
$action = $params["action"];

require "src/controllers/$controller.php";

$controller_object = new $controller;
    $controller_object->$action();