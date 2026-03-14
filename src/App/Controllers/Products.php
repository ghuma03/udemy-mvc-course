<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;
use Framework\Exceptions\PageNotFoundException;

class Products {

    private Viewer $viewer;
    private Product $model;

    public function __construct(Viewer $viewer, Product $model) {
        $this->viewer = $viewer;
        $this->model = $model;
    }

    public function index() {

        $products = $this->model->getData();

        echo $this->viewer->render("shared/header.php", array("title" => "Products"));
        echo $this->viewer->render("Products/index.php", array("products" => $products));
    }

    public function show(string $id) {

        $product = $this->model->find($id);

        if ($product === false) {
            throw new PageNotFoundException("Product not found");
        }

        echo $this->viewer->render("shared/header.php", array("title" => "Products"));
        echo $this->viewer->render("Products/show.php", array("product" => $product));
    }

    public function showPage(string $title, string $id, string $page) {
        echo "title: " . $title . "\n";
        echo "id: " . $id . "\n";
        echo "page: " . $page;
        die();
    }

    public function new() {
        echo $this->viewer->render("shared/header.php", array("title" => "New Product"));
        echo $this->viewer->render("Products/new.php");
    }

    public function create() {

        $data = array(
            "name" => $_POST["name"],
            "description" => $_POST["description"]
        );

        var_dump($this->model->insert($data));
    }
}