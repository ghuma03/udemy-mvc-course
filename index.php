<?php

$controller = $_GET["controller"];
$action = $_GET["action"];

require "src/controllers/$controller.php";

$controller_object = new $controller;
    $controller_object->$action();