<?php

require "src/controllers/products.php";

$controller = new Products;

$action = $_GET["action"];

switch ($action) {
    case "index":
        $controller->index();
        break;
    case "show":
        $controller->show();
        break;
    default:
        echo "Action not found!";
}