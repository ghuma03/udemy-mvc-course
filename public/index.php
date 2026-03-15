<?php

declare(strict_types = 1);

DEFINE("ROOT_FOLDER", dirname(__DIR__));

spl_autoload_register(function($class_name) {
    require ROOT_FOLDER . "/src/".str_replace("\\", "/", $class_name).".php";
});

$dotenv = new Framework\Dotenv;
    $dotenv->load(ROOT_FOLDER . "/.env");

set_error_handler("Framework\ErrorHandler::handleError");
set_exception_handler("Framework\ErrorHandler::handleException");

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

if ($path === false) {
    throw new UnexpectedValueException("Malformed URL: '{$_SERVER["REQUEST_URI"]}'");
}

$router = require ROOT_FOLDER . "/config/routes.php";
$container = require ROOT_FOLDER . "/config/services.php";

$dispatcher = new Framework\Dispatcher($router, $container);
    $dispatcher->handle($path, $_SERVER["REQUEST_METHOD"]);