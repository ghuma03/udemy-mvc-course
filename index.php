<?php

$controller = $_GET["controller"];
$action = $_GET["action"];

switch ($controller) {

    case "products":
        require "src/controllers/products.php";
        $controller = new Products;
        break;

    case "home":
        require "src/controllers/home.php";
        $controller = new Home;
        break;
    
    default:
        echo "Controller not found!";
        die();
}

switch ($action) {
    case "index":
        $controller->index();
        break;
    case "show":
        $controller->show();
        break;
    default:
        echo "Action not found!";
        die();
}