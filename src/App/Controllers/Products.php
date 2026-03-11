<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

class Products {

    private Viewer $viewer;

    public function __construct(Viewer $viewer) {
        $this->viewer = $viewer;
    }

    public function index() {

        $model = new Product;

        $products = $model->getData();

        echo $this->viewer->render("shared/header.php", array("title" => "Products"));
        echo $this->viewer->render("Products/index.php", array("products" => $products));
    }

    public function show(string $id) {
        echo $this->viewer->render("shared/header.php", array("title" => "Products"));
        echo $this->viewer->render("Products/show.php", array("id" => $id));
    }

    public function showPage(string $title, string $id, string $page) {
        echo "title: " . $title . "\n";
        echo "id: " . $id . "\n";
        echo "page: " . $page;
        die();
    }

}