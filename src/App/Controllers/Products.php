<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

class Products {

    private Viewer $viewer;
    private Product $model;

    public function __construct( $viewer, Product $model) {
        $this->viewer = $viewer;
        $this->model = $model;
    }

    public function index() {

        $products = $this->model->getData();

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