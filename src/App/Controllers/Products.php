<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

class Products {

    public function index() {

        $model = new Product;

        $products = $model->getData();

        $viewer = new Viewer;
        echo $viewer->render("Products/index.php", array("products" => $products));
    }

    public function show(string $id) {
        $viewer = new Viewer;
        echo $viewer->render("Products/show.php", array("id" => $id));
    }

    public function showPage(string $title, string $id, string $page) {
        echo "title: " . $title . "\n";
        echo "id: " . $id . "\n";
        echo "page: " . $page;
        die();
    }

}