<?php

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$segments = explode("/", $path);

$controller = $segments[1];
$action = $segments[2];

require "src/controllers/$controller.php";

$controller_object = new $controller;
    $controller_object->$action();